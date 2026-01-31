@extends('layouts.app')
@section('title')
  {{ __('messages.template_editor.title') }}
@endsection
@push('css')
  <style>
    .template-editor-container {
      display: flex;
      height: calc(100vh - 200px);
      min-height: 600px;
      gap: 15px;
    }

    .file-browser {
      width: 300px;
      min-width: 250px;
      max-width: 400px;
      background: var(--bs-card-bg, #fff);
      border-radius: 8px;
      border: 1px solid var(--bs-border-color, #e0e0e0);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .file-browser-header {
      padding: 15px;
      border-bottom: 1px solid var(--bs-border-color, #e0e0e0);
      background: var(--bs-card-cap-bg, #f8f9fa);
    }

    .file-browser-header h5 {
      margin: 0;
      font-size: 14px;
      font-weight: 600;
    }

    .file-browser-content {
      flex: 1;
      overflow-y: auto;
      padding: 10px;
    }

    .file-tree {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .file-tree ul {
      list-style: none;
      padding-left: 20px;
      margin: 0;
    }

    .file-tree-item {
      padding: 6px 10px;
      cursor: pointer;
      border-radius: 4px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      transition: background-color 0.15s;
    }

    .file-tree-item:hover {
      background-color: var(--bs-light, #f0f0f0);
    }

    .file-tree-item.active {
      background-color: var(--bs-primary);
      color: #fff;
    }

    .file-tree-item.directory {
      font-weight: 500;
    }

    .file-tree-item i {
      width: 16px;
      text-align: center;
    }

    .file-tree-item .expand-icon {
      width: 12px;
      font-size: 10px;
    }

    .editor-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: var(--bs-card-bg, #fff);
      border-radius: 8px;
      border: 1px solid var(--bs-border-color, #e0e0e0);
      overflow: hidden;
      min-height: 600px;
    }

    .editor-header {
      padding: 10px 15px;
      border-bottom: 1px solid var(--bs-border-color, #e0e0e0);
      background: var(--bs-card-cap-bg, #f8f9fa);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-shrink: 0;
    }

    .editor-tabs {
      display: flex;
      gap: 5px;
      flex-wrap: wrap;
    }

    .editor-tab {
      padding: 6px 12px;
      background: var(--bs-light, #e9ecef);
      border-radius: 4px;
      font-size: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      border: none;
    }

    .editor-tab.active {
      background: var(--bs-primary);
      color: #fff;
    }

    .editor-tab .close-tab {
      opacity: 0.7;
      font-size: 10px;
    }

    .editor-tab .close-tab:hover {
      opacity: 1;
    }

    .editor-tab.modified::after {
      content: '●';
      margin-left: 4px;
      color: var(--bs-warning);
    }

    .editor-actions {
      display: flex;
      gap: 10px;
    }

    .editor-content {
      flex: 1;
      position: relative;
      overflow: hidden;
    }

    #ace-editor {
      width: 100%;
      height: 100%;
      font-size: 14px;
    }

    .no-file-selected {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      color: var(--bs-secondary);
    }

    .no-file-selected i {
      font-size: 48px;
      margin-bottom: 15px;
      opacity: 0.5;
    }

    .file-context-menu {
      position: fixed;
      background: var(--bs-card-bg, #fff);
      border: 1px solid var(--bs-border-color, #e0e0e0);
      border-radius: 4px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      min-width: 150px;
    }

    .file-context-menu-item {
      padding: 8px 15px;
      cursor: pointer;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .file-context-menu-item:hover {
      background: var(--bs-light, #f0f0f0);
    }

    .status-bar {
      padding: 5px 15px;
      border-top: 1px solid var(--bs-border-color, #e0e0e0);
      font-size: 11px;
      color: var(--bs-secondary);
      display: flex;
      justify-content: space-between;
      flex-shrink: 0;
    }
  </style>
@endpush

@section('content')
  <div class="container-fluid">
    <div class="d-flex flex-column">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-end mb-4">
          <h1>{{ __('messages.template_editor.title') }}</h1>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" id="btn-refresh-tree">
              <i class="fas fa-sync-alt"></i> {{ __('messages.common.refresh') }}
            </button>
          </div>
        </div>

        <div class="template-editor-container">
          <!-- File Browser -->
          <div class="file-browser">
            <div class="file-browser-header">
              <h5><i class="fas fa-folder-tree me-2"></i>{{ __('messages.template_editor.files') }}</h5>
            </div>
            <div class="file-browser-content">
              <ul class="file-tree" id="file-tree">
                @foreach ($directories as $dir)
                  <li>
                    <div class="file-tree-item directory" data-path="{{ $dir['path'] }}" data-type="directory">
                      <i class="fas fa-chevron-right expand-icon"></i>
                      <i class="fas fa-folder text-warning"></i>
                      <span>{{ $dir['name'] }}</span>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          <!-- Editor Panel -->
          <div class="editor-panel">
            <div class="editor-header">
              <div class="editor-tabs" id="editor-tabs"></div>
              <div class="editor-actions">
                <button class="btn btn-sm btn-outline-secondary" id="btn-backups"
                  title="{{ __('messages.template_editor.backups') }}" disabled>
                  <i class="fas fa-history"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary" id="btn-duplicate"
                  title="{{ __('messages.template_editor.duplicate') }}" disabled>
                  <i class="fas fa-copy"></i>
                </button>
                <button class="btn btn-sm btn-primary" id="btn-save" disabled>
                  <i class="fas fa-save me-1"></i> {{ __('messages.common.save') }}
                </button>
              </div>
            </div>
            <div class="editor-content">
              <div class="no-file-selected" id="no-file-message">
                <i class="fas fa-file-code"></i>
                <p>{{ __('messages.template_editor.select_file') }}</p>
              </div>
              <div id="ace-editor" style="display: none;"></div>
            </div>
            <div class="status-bar">
              <span id="status-file-path">{{ __('messages.template_editor.no_file') }}</span>
              <span id="status-language">-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Context Menu -->
  <div class="file-context-menu" id="context-menu" style="display: none;">
    <div class="file-context-menu-item" data-action="open">
      <i class="fas fa-folder-open"></i> {{ __('messages.template_editor.open') }}
    </div>
    <div class="file-context-menu-item" data-action="duplicate">
      <i class="fas fa-copy"></i> {{ __('messages.template_editor.duplicate') }}
    </div>
    <div class="file-context-menu-item" data-action="new-file">
      <i class="fas fa-file-plus"></i> {{ __('messages.template_editor.new_file') }}
    </div>
  </div>

  <!-- Duplicate Modal -->
  <div class="modal fade" id="duplicateModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('messages.template_editor.duplicate') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">{{ __('messages.template_editor.new_name') }}</label>
            <input type="text" class="form-control" id="duplicate-new-name">
            <input type="hidden" id="duplicate-source-path">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
          <button type="button" class="btn btn-primary" id="btn-confirm-duplicate">{{ __('messages.template_editor.duplicate') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- New File Modal -->
  <div class="modal fade" id="newFileModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('messages.template_editor.new_file') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">{{ __('messages.template_editor.directory') }}</label>
            <input type="text" class="form-control" id="new-file-directory" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('messages.template_editor.filename') }}</label>
            <input type="text" class="form-control" id="new-file-name" placeholder="e.g., vcard40.blade.php">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
          <button type="button" class="btn btn-primary" id="btn-confirm-new-file">{{ __('messages.common.create') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Backups Modal -->
  <div class="modal fade" id="backupsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('messages.template_editor.file_backups') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="backups-list"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.36.3/ace.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.36.3/ext-language_tools.min.js"></script>
  <script>
    let editor = null;
    let openTabs = {};
    let activeTab = null;

    document.addEventListener('DOMContentLoaded', function() {
      // Initialize ACE Editor
      ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.36.3/');

      document.getElementById('file-tree').addEventListener('click', function(e) {
        let item = e.target.closest('.file-tree-item');
        if (!item) return;

        let path = item.dataset.path;
        let type = item.dataset.type;

        if (type === 'directory') {
          toggleDirectory(item);
        } else {
          openFile(path);
        }
      });

      function toggleDirectory(item) {
        let path = item.dataset.path;
        let li = item.parentElement;
        let existingUl = li.querySelector('ul');
        let expandIcon = item.querySelector('.expand-icon');

        if (existingUl) {
          if (existingUl.style.display === 'none') {
            existingUl.style.display = '';
            expandIcon.classList.remove('fa-chevron-right');
            expandIcon.classList.add('fa-chevron-down');
          } else {
            existingUl.style.display = 'none';
            expandIcon.classList.remove('fa-chevron-down');
            expandIcon.classList.add('fa-chevron-right');
          }
        } else {
          loadDirectory(path, li, expandIcon);
        }
      }

      function loadDirectory(path, parentLi, expandIcon) {
        fetch('{{ route('template-editor.directory-tree') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ path: path })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              let ul = document.createElement('ul');
              data.data.forEach(item => {
                let li = document.createElement('li');
                let div = document.createElement('div');
                div.className = 'file-tree-item ' + item.type;
                div.dataset.path = item.path;
                div.dataset.type = item.type;

                if (item.type === 'directory') {
                  div.innerHTML = `
                    <i class="fas fa-chevron-right expand-icon"></i>
                    <i class="fas fa-folder text-warning"></i>
                    <span>${item.name}</span>
                  `;
                } else {
                  let icon = getFileIcon(item.extension);
                  div.innerHTML = `<i class="${icon}"></i><span>${item.name}</span>`;
                }

                li.appendChild(div);
                ul.appendChild(li);
              });

              parentLi.appendChild(ul);
              expandIcon.classList.remove('fa-chevron-right');
              expandIcon.classList.add('fa-chevron-down');
            } else {
              toastr.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            toastr.error('Failed to load directory');
          });
      }

      function getFileIcon(extension) {
        const icons = {
          'blade.php': 'fab fa-php text-primary',
          'php': 'fab fa-php text-primary',
          'css': 'fab fa-css3 text-info',
          'js': 'fab fa-js text-warning',
          'html': 'fab fa-html5 text-danger'
        };
        return icons[extension] || 'fas fa-file-code text-secondary';
      }

      function getAceMode(language) {
        const modes = {
          'php': 'ace/mode/php',
          'html': 'ace/mode/html',
          'css': 'ace/mode/css',
          'javascript': 'ace/mode/javascript',
          'js': 'ace/mode/javascript'
        };
        return modes[language] || 'ace/mode/html';
      }

      function createEditor() {
        if (editor) return;

        editor = ace.edit('ace-editor');
        editor.setTheme('ace/theme/monokai');
        editor.setOptions({
          enableBasicAutocompletion: true,
          enableLiveAutocompletion: true,
          enableSnippets: true,
          showPrintMargin: false,
          fontSize: '14px',
          wrap: true
        });

        editor.on('change', function() {
          if (activeTab && openTabs[activeTab]) {
            openTabs[activeTab].modified = true;
            openTabs[activeTab].content = editor.getValue();
            updateTabDisplay();
          }
        });

        editor.commands.addCommand({
          name: 'save',
          bindKey: {win: 'Ctrl-S', mac: 'Command-S'},
          exec: function() {
            saveCurrentFile();
          }
        });
      }

      function openFile(path) {
        if (openTabs[path]) {
          switchToTab(path);
          return;
        }

        fetch('{{ route('template-editor.file-content') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ path: path })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              openTabs[path] = {
                content: data.data.content,
                originalContent: data.data.content,
                language: data.data.language,
                filename: data.data.filename,
                modified: false
              };

              addTab(path, data.data.filename);
              switchToTab(path);
            } else {
              toastr.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            toastr.error('Failed to load file');
          });
      }

      function addTab(path, filename) {
        let tabsContainer = document.getElementById('editor-tabs');
        let tab = document.createElement('button');
        tab.className = 'editor-tab';
        tab.dataset.path = path;
        tab.innerHTML = `
          <span class="tab-name">${filename}</span>
          <i class="fas fa-times close-tab"></i>
        `;

        tab.addEventListener('click', function(e) {
          if (e.target.classList.contains('close-tab')) {
            closeTab(path);
          } else {
            switchToTab(path);
          }
        });

        tabsContainer.appendChild(tab);
      }

      function switchToTab(path) {
        if (activeTab && openTabs[activeTab] && editor) {
          openTabs[activeTab].content = editor.getValue();
        }

        activeTab = path;

        document.querySelectorAll('.editor-tab').forEach(tab => {
          tab.classList.toggle('active', tab.dataset.path === path);
        });

        document.getElementById('no-file-message').style.display = 'none';
        document.getElementById('ace-editor').style.display = 'block';

        if (!editor) {
          createEditor();
        }

        let tabData = openTabs[path];
        editor.setValue(tabData.content, -1);
        editor.session.setMode(getAceMode(tabData.language));
        editor.focus();

        document.getElementById('status-file-path').textContent = path;
        document.getElementById('status-language').textContent = (tabData.language || 'TEXT').toUpperCase();

        document.getElementById('btn-save').disabled = false;
        document.getElementById('btn-backups').disabled = false;
        document.getElementById('btn-duplicate').disabled = false;

        updateTabDisplay();
      }

      function closeTab(path) {
        if (openTabs[path].modified) {
          if (!confirm('You have unsaved changes. Close anyway?')) {
            return;
          }
        }

        delete openTabs[path];
        let tab = document.querySelector(`.editor-tab[data-path="${path}"]`);
        if (tab) tab.remove();

        let remainingTabs = Object.keys(openTabs);
        if (remainingTabs.length > 0) {
          switchToTab(remainingTabs[remainingTabs.length - 1]);
        } else {
          activeTab = null;
          document.getElementById('ace-editor').style.display = 'none';
          document.getElementById('no-file-message').style.display = 'flex';
          document.getElementById('status-file-path').textContent = 'No file selected';
          document.getElementById('status-language').textContent = '-';
          document.getElementById('btn-save').disabled = true;
          document.getElementById('btn-backups').disabled = true;
          document.getElementById('btn-duplicate').disabled = true;
        }
      }

      function updateTabDisplay() {
        document.querySelectorAll('.editor-tab').forEach(tab => {
          let path = tab.dataset.path;
          if (openTabs[path]) {
            tab.classList.toggle('modified', openTabs[path].modified);
          }
        });
      }

      function saveCurrentFile() {
        if (!activeTab || !openTabs[activeTab] || !editor) return;

        let content = editor.getValue();

        fetch('{{ route('template-editor.save') }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              path: activeTab,
              content: content
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              openTabs[activeTab].originalContent = content;
              openTabs[activeTab].modified = false;
              updateTabDisplay();
              toastr.success(data.message);
            } else {
              toastr.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            toastr.error('Failed to save file');
          });
      }

      document.getElementById('btn-save').addEventListener('click', saveCurrentFile);
      document.getElementById('btn-refresh-tree').addEventListener('click', () => location.reload());

      document.getElementById('btn-duplicate').addEventListener('click', function() {
        if (!activeTab) return;
        document.getElementById('duplicate-source-path').value = activeTab;
        document.getElementById('duplicate-new-name').value = 'copy_' + openTabs[activeTab].filename;
        new bootstrap.Modal(document.getElementById('duplicateModal')).show();
      });

      document.getElementById('btn-confirm-duplicate').addEventListener('click', function() {
        let sourcePath = document.getElementById('duplicate-source-path').value;
        let newName = document.getElementById('duplicate-new-name').value;

        fetch('{{ route('template-editor.duplicate') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({source_path: sourcePath, new_name: newName})
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              toastr.success(data.message);
              bootstrap.Modal.getInstance(document.getElementById('duplicateModal')).hide();
              location.reload();
            } else {
              toastr.error(data.message);
            }
          });
      });

      document.getElementById('btn-backups').addEventListener('click', function() {
        if (!activeTab) return;

        fetch('{{ route('template-editor.backups') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ path: activeTab })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              let html = data.data.length === 0 ? '<p class="text-muted text-center">No backups available</p>' :
                '<table class="table table-striped"><thead><tr><th>Date</th><th>Actions</th></tr></thead><tbody>' +
                data.data.map(b => `<tr><td>${b.date}</td><td><button class="btn btn-sm btn-outline-primary restore-backup" data-file="${b.file}"><i class="fas fa-undo"></i> Restore</button></td></tr>`).join('') +
                '</tbody></table>';
              document.getElementById('backups-list').innerHTML = html;
              new bootstrap.Modal(document.getElementById('backupsModal')).show();
            }
          });
      });

      document.getElementById('backups-list').addEventListener('click', function(e) {
        let btn = e.target.closest('.restore-backup');
        if (!btn || !confirm('Restore this backup?')) return;

        fetch('{{ route('template-editor.restore') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({path: activeTab, backup_file: btn.dataset.file})
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              toastr.success(data.message);
              bootstrap.Modal.getInstance(document.getElementById('backupsModal')).hide();
              let p = activeTab;
              closeTab(p);
              openFile(p);
            }
          });
      });

      document.getElementById('file-tree').addEventListener('contextmenu', function(e) {
        let item = e.target.closest('.file-tree-item');
        if (!item) return;
        e.preventDefault();

        let menu = document.getElementById('context-menu');
        menu.style.display = 'block';
        menu.style.left = e.pageX + 'px';
        menu.style.top = e.pageY + 'px';
        menu.dataset.targetPath = item.dataset.path;
        menu.dataset.targetType = item.dataset.type;
      });

      document.addEventListener('click', () => document.getElementById('context-menu').style.display = 'none');

      document.getElementById('context-menu').addEventListener('click', function(e) {
        let item = e.target.closest('.file-context-menu-item');
        if (!item) return;

        let path = this.dataset.targetPath;
        let type = this.dataset.targetType;

        if (item.dataset.action === 'open') {
          type === 'directory' ? toggleDirectory(document.querySelector(`.file-tree-item[data-path="${path}"]`)) : openFile(path);
        } else if (item.dataset.action === 'duplicate') {
          document.getElementById('duplicate-source-path').value = path;
          document.getElementById('duplicate-new-name').value = 'copy_' + path.split('/').pop();
          new bootstrap.Modal(document.getElementById('duplicateModal')).show();
        } else if (item.dataset.action === 'new-file') {
          document.getElementById('new-file-directory').value = type === 'directory' ? path : path.substring(0, path.lastIndexOf('/'));
          new bootstrap.Modal(document.getElementById('newFileModal')).show();
        }
        this.style.display = 'none';
      });

      document.getElementById('btn-confirm-new-file').addEventListener('click', function() {
        fetch('{{ route('template-editor.create-file') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({
              directory: document.getElementById('new-file-directory').value,
              filename: document.getElementById('new-file-name').value
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              toastr.success(data.message);
              bootstrap.Modal.getInstance(document.getElementById('newFileModal')).hide();
              location.reload();
            } else {
              toastr.error(data.message);
            }
          });
      });

      window.openFile = openFile;
      window.closeTab = closeTab;
    });
  </script>
@endpush
