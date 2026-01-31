<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class TemplateEditorController extends AppBaseController
{
  /**
   * Allowed directories for editing (relative to base_path)
   */
  protected array $allowedDirectories = [
    'resources/views/vcardTemplates',
    'resources/views/oldVcardTemplates',
    'public/assets/css',
    'public/assets/js',
  ];

  /**
   * Allowed file extensions
   */
  protected array $allowedExtensions = [
    'blade.php',
    'php',
    'css',
    'js',
    'html'
  ];

  /**
   * Display file browser
   */
  public function index(): View
  {
    $directories = $this->getEditableDirectories();
    return view('sadmin.template-editor.index', compact('directories'));
  }

  /**
   * Get directory tree for a specific path
   */
  public function getDirectoryTree(Request $request): JsonResponse
  {
    $path = $request->input('path', '');

    if (!$this->isPathAllowed($path)) {
      return $this->sendError('Access denied to this directory');
    }

    $fullPath = base_path($path);

    if (!File::isDirectory($fullPath)) {
      return $this->sendError('Directory not found');
    }

    $items = $this->scanDirectory($fullPath, $path);

    return $this->sendResponse($items, 'Directory tree loaded successfully');
  }

  /**
   * Get file content for editing
   */
  public function getFileContent(Request $request): JsonResponse
  {
    $path = $request->input('path');

    if (!$this->isPathAllowed($path)) {
      return $this->sendError('Access denied to this file');
    }

    if (!$this->isFileExtensionAllowed($path)) {
      return $this->sendError('File type not allowed for editing');
    }

    $fullPath = base_path($path);

    if (!File::exists($fullPath)) {
      return $this->sendError('File not found');
    }

    $content = File::get($fullPath);
    $extension = $this->getFileExtension($path);
    $language = $this->getEditorLanguage($extension);

    return $this->sendResponse([
      'content' => $content,
      'path' => $path,
      'filename' => basename($path),
      'language' => $language,
      'extension' => $extension,
    ], 'File content loaded successfully');
  }

  /**
   * Save file content
   */
  public function saveFile(Request $request): JsonResponse
  {
    $request->validate([
      'path' => 'required|string',
      'content' => 'required|string',
    ]);

    $path = $request->input('path');
    $content = $request->input('content');

    if (!$this->isPathAllowed($path)) {
      return $this->sendError('Access denied to this file');
    }

    if (!$this->isFileExtensionAllowed($path)) {
      return $this->sendError('File type not allowed for editing');
    }

    $fullPath = base_path($path);

    if (!File::exists($fullPath)) {
      return $this->sendError('File not found');
    }

    // Create backup before saving
    $this->createBackup($fullPath);

    try {
      File::put($fullPath, $content);
      return $this->sendSuccess('File saved successfully');
    } catch (\Exception $e) {
      return $this->sendError('Failed to save file: ' . $e->getMessage());
    }
  }

  /**
   * Duplicate a template file or folder
   */
  public function duplicate(Request $request): JsonResponse
  {
    $request->validate([
      'source_path' => 'required|string',
      'new_name' => 'required|string|regex:/^[a-zA-Z0-9_\-\.]+$/',
    ]);

    $sourcePath = $request->input('source_path');
    $newName = $request->input('new_name');

    if (!$this->isPathAllowed($sourcePath)) {
      return $this->sendError('Access denied to this file');
    }

    $fullSourcePath = base_path($sourcePath);

    if (!File::exists($fullSourcePath)) {
      return $this->sendError('Source file/folder not found');
    }

    $parentDir = dirname($fullSourcePath);
    $newPath = $parentDir . DIRECTORY_SEPARATOR . $newName;
    $relativePath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $newPath);

    if (File::exists($newPath)) {
      return $this->sendError('A file/folder with this name already exists');
    }

    try {
      if (File::isDirectory($fullSourcePath)) {
        File::copyDirectory($fullSourcePath, $newPath);
      } else {
        File::copy($fullSourcePath, $newPath);
      }

      return $this->sendResponse([
        'new_path' => $relativePath,
      ], 'Duplicated successfully');
    } catch (\Exception $e) {
      return $this->sendError('Failed to duplicate: ' . $e->getMessage());
    }
  }

  /**
   * Create a new file
   */
  public function createFile(Request $request): JsonResponse
  {
    $request->validate([
      'directory' => 'required|string',
      'filename' => 'required|string|regex:/^[a-zA-Z0-9_\-\.]+$/',
    ]);

    $directory = $request->input('directory');
    $filename = $request->input('filename');

    if (!$this->isPathAllowed($directory)) {
      return $this->sendError('Access denied to this directory');
    }

    $fullPath = base_path($directory) . DIRECTORY_SEPARATOR . $filename;
    $relativePath = $directory . '/' . $filename;

    if (!$this->isFileExtensionAllowed($relativePath)) {
      return $this->sendError('File type not allowed');
    }

    if (File::exists($fullPath)) {
      return $this->sendError('A file with this name already exists');
    }

    try {
      // Create with default content based on file type
      $defaultContent = $this->getDefaultContent($filename);
      File::put($fullPath, $defaultContent);

      return $this->sendResponse([
        'path' => $relativePath,
      ], 'File created successfully');
    } catch (\Exception $e) {
      return $this->sendError('Failed to create file: ' . $e->getMessage());
    }
  }

  /**
   * Get list of backups for a file
   */
  public function getBackups(Request $request): JsonResponse
  {
    $path = $request->input('path');

    if (!$this->isPathAllowed($path)) {
      return $this->sendError('Access denied to this file');
    }

    $backupDir = storage_path('app/template-backups');
    $filename = md5($path);
    $backups = [];

    if (File::isDirectory($backupDir)) {
      $files = File::glob($backupDir . '/' . $filename . '_*');
      foreach ($files as $file) {
        $timestamp = str_replace($filename . '_', '', basename($file));
        $backups[] = [
          'file' => basename($file),
          'timestamp' => $timestamp,
          'date' => date('Y-m-d H:i:s', (int)$timestamp),
        ];
      }
      // Sort by timestamp descending
      usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
    }

    return $this->sendResponse($backups, 'Backups loaded successfully');
  }

  /**
   * Restore a backup
   */
  public function restoreBackup(Request $request): JsonResponse
  {
    $request->validate([
      'path' => 'required|string',
      'backup_file' => 'required|string',
    ]);

    $path = $request->input('path');
    $backupFile = $request->input('backup_file');

    if (!$this->isPathAllowed($path)) {
      return $this->sendError('Access denied to this file');
    }

    $backupPath = storage_path('app/template-backups/' . $backupFile);
    $fullPath = base_path($path);

    if (!File::exists($backupPath)) {
      return $this->sendError('Backup file not found');
    }

    // Create a backup of current state before restoring
    $this->createBackup($fullPath);

    try {
      $content = File::get($backupPath);
      File::put($fullPath, $content);
      return $this->sendSuccess('Backup restored successfully');
    } catch (\Exception $e) {
      return $this->sendError('Failed to restore backup: ' . $e->getMessage());
    }
  }

  /**
   * Get editable directories structure
   */
  protected function getEditableDirectories(): array
  {
    $directories = [];

    foreach ($this->allowedDirectories as $dir) {
      $fullPath = base_path($dir);
      if (File::isDirectory($fullPath)) {
        $directories[] = [
          'path' => $dir,
          'name' => basename($dir),
          'type' => 'directory',
        ];
      }
    }

    return $directories;
  }

  /**
   * Scan directory and return items
   */
  protected function scanDirectory(string $fullPath, string $relativePath): array
  {
    $items = [];
    $entries = File::directories($fullPath);

    // Add directories first
    foreach ($entries as $entry) {
      $name = basename($entry);
      $items[] = [
        'name' => $name,
        'path' => $relativePath . '/' . $name,
        'type' => 'directory',
        'children' => [],
      ];
    }

    // Add files
    $files = File::files($fullPath);
    foreach ($files as $file) {
      $name = $file->getFilename();
      $extension = $this->getFileExtension($name);

      if ($this->isFileExtensionAllowed($name)) {
        $items[] = [
          'name' => $name,
          'path' => $relativePath . '/' . $name,
          'type' => 'file',
          'extension' => $extension,
          'size' => $file->getSize(),
          'modified' => date('Y-m-d H:i:s', $file->getMTime()),
        ];
      }
    }

    // Sort: directories first, then files alphabetically
    usort($items, function ($a, $b) {
      if ($a['type'] !== $b['type']) {
        return $a['type'] === 'directory' ? -1 : 1;
      }
      return strcasecmp($a['name'], $b['name']);
    });

    return $items;
  }

  /**
   * Check if path is within allowed directories
   */
  protected function isPathAllowed(string $path): bool
  {
    $normalizedPath = str_replace('\\', '/', $path);

    foreach ($this->allowedDirectories as $allowedDir) {
      if (strpos($normalizedPath, $allowedDir) === 0) {
        return true;
      }
    }

    return false;
  }

  /**
   * Check if file extension is allowed
   */
  protected function isFileExtensionAllowed(string $path): bool
  {
    foreach ($this->allowedExtensions as $ext) {
      if (str_ends_with(strtolower($path), '.' . $ext)) {
        return true;
      }
    }
    return false;
  }

  /**
   * Get file extension
   */
  protected function getFileExtension(string $path): string
  {
    if (str_ends_with(strtolower($path), '.blade.php')) {
      return 'blade.php';
    }
    return pathinfo($path, PATHINFO_EXTENSION);
  }

  /**
   * Get Monaco editor language based on extension
   */
  protected function getEditorLanguage(string $extension): string
  {
    return match ($extension) {
      'blade.php', 'php' => 'php',
      'css' => 'css',
      'js' => 'javascript',
      'html' => 'html',
      default => 'plaintext',
    };
  }

  /**
   * Create a backup of the file
   */
  protected function createBackup(string $fullPath): void
  {
    $backupDir = storage_path('app/template-backups');

    if (!File::isDirectory($backupDir)) {
      File::makeDirectory($backupDir, 0755, true);
    }

    $relativePath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $fullPath);
    $backupFilename = md5($relativePath) . '_' . time();

    File::copy($fullPath, $backupDir . '/' . $backupFilename);

    // Keep only last 10 backups
    $this->cleanOldBackups($relativePath);
  }

  /**
   * Clean old backups, keep only last 10
   */
  protected function cleanOldBackups(string $relativePath): void
  {
    $backupDir = storage_path('app/template-backups');
    $filename = md5($relativePath);

    $files = File::glob($backupDir . '/' . $filename . '_*');

    if (count($files) > 10) {
      // Sort by modification time
      usort($files, fn($a, $b) => filemtime($a) <=> filemtime($b));

      // Delete oldest files
      $toDelete = array_slice($files, 0, count($files) - 10);
      foreach ($toDelete as $file) {
        File::delete($file);
      }
    }
  }

  /**
   * Get default content for new files
   */
  protected function getDefaultContent(string $filename): string
  {
    $extension = $this->getFileExtension($filename);

    return match ($extension) {
      'blade.php' => "{{-- New Blade Template --}}\n<div>\n    \n</div>\n",
      'php' => "<?php\n\n",
      'css' => "/* New CSS File */\n\n",
      'js' => "// New JavaScript File\n\n",
      'html' => "<!DOCTYPE html>\n<html>\n<head>\n    <title></title>\n</head>\n<body>\n    \n</body>\n</html>\n",
      default => '',
    };
  }
}
