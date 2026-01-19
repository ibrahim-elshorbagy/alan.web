<script>
  var steps = {{ getLogInUser()->steps }};
  var hasActiveSub = {{ json_encode(hasActiveSubscription()) }};


  if (steps == 0 && hasActiveSub == true) {
    if (performance.navigation.type === 1) {
      window.location.href = '/admin/dashboard';
    }

    const tour = new Shepherd.Tour({
      useModalOverlay: true,
      defaultStepOptions: {
        classes: 'shadow-md bg-purple-dark',
        scrollTo: true
      }
    });

    let currentPath = window.location.pathname;
    // Step 1: Navigate from subscription management to dashboard
    if (currentPath === '/admin/manage-subscription') {
      if (window.innerWidth < 1200) {
        $("#sidebar").addClass("collapsed-menu");
        $("body").addClass("collapsed-menu");
      }
      tour.addStep({
        id: 'step-1',
        text: Lang.get("js.click_to_go_dashboard"),
        attachTo: {
          element: '.user-dashboard ',
          on: 'bottom'
        },
        beforeShowPromise: function() {
          return new Promise(function(resolve) {
            $('html, body').animate({
              scrollTop: $('.user-dashboard').offset().top - 100
            }, 500, function() {
              resolve();
            });
          });
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              localStorage.setItem('startFromStep3', 'true');
              window.location.href = '/admin/dashboard';
            }
          }
        ]
      });
    }

    // Step 3: Show Vcard on the side menu (only on dashboard)
    if (currentPath.includes('dashboard')) {
      tour.addStep({
        id: 'step-3',
        text: Lang.get("js.show_vcard_sidebar"),
        attachTo: {
          element: '.vcard-option',
          on: 'right'
        },
        beforeShowPromise: function() {
          return new Promise(function(resolve) {
            if ($(window).width() < 1200) {
              resolve();
            } else {
              resolve();
            }
          });
        },
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            classes: 'shepherd-button-example-primary',
            action: function() {
              tour.show('step-4');
            }
          }
        ]
      });
    }

    // Step 4: Show RedirectLinks on the side menu (only on dashboard)
    if (currentPath.includes('dashboard')) {
      tour.addStep({
        id: 'step-4',
        text: Lang.get("js.show_redirect_links_sidebar"),
        attachTo: {
          element: '.redirect-links-option',
          on: 'right'
        },
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            classes: 'shepherd-button-example-primary',
            action: function() {
              // Navigate to redirect links page to show the modal
              localStorage.setItem('startFromStep6', 'true');
              window.location.href = '{{ route('client.redirect-links.index') }}';
            }
          }
        ]
      });
    }

    // Step 6: Show how to use redirect link code by opening #redeemModal
    if (window.location.pathname.includes('redirect-links')) {
      tour.addStep({
        id: 'step-6',
        text: Lang.get("js.open_redeem_modal"),
        attachTo: {
          element: '[data-bs-target="#redeemModal"]',
          on: 'bottom'
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              // Open redeem modal
              $('#redeemModal').modal('show');
              setTimeout(() => tour.show('step-7'), 500);
            }
          }
        ]
      });

      // Step 7: Tell him to enter the redirect code
      tour.addStep({
        id: 'step-7',
        text: Lang.get("js.enter_redirect_code"),
        attachTo: {
          element: '#uri',
          on: 'bottom'
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $('#redeemModal').modal('hide');
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              tour.show('step-8');
            }
          }
        ]
      });

      // Step 8: And save button
      tour.addStep({
        id: 'step-8',
        text: Lang.get("js.save_redirect_code"),
        attachTo: {
          element: '#redeemModal .btn-success',
          on: 'bottom'
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $('#redeemModal').modal('hide');
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              tour.show('step-9');
            }
          }
        ]
      });

      // Step 9: If he did not have code he can close it
      tour.addStep({
        id: 'step-9',
        text: Lang.get("js.close_if_no_code"),
        attachTo: {
          element: '#redeemModal .btn-secondary',
          on: 'top'
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $('#redeemModal').modal('hide');
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              $('#redeemModal').modal('hide');
              tour.show('step-10');
            }
          }
        ]
      });

      // Step 10: Explain vCard and navigate
      tour.addStep({
        id: 'step-10',
        text: Lang.get("js.redeem_vcard_code") +
          " ",
        attachTo: {
          element: '.vcard-option',
          on: 'right'
        },
        classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $('#redeemModal').modal('hide');
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              $('#redeemModal').modal('hide');
              // Navigate to vCard page
              localStorage.setItem('startFromStep11', 'true');
              window.location.href = '{{ route('vcards.index') }}';
            }
          }
        ]
      });
    }

    // vCard creation steps
    if (window.location.pathname === '/admin/vcards') {
      // Step 11: Click to make new vCards
      tour.addStep({
        id: 'step-11',
        text: Lang.get("js.click_to_make_vcards"),
        attachTo: {
          element: '.create-vcard-btn',
          on: 'bottom'
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.finish"),
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          }
        ]
      });

      // Step 12: Click to create your vCard
      tour.addStep({
        id: 'step-12',
        text: Lang.get("js.click_to_create_vcards"),
        attachTo: {
          element: '.create-vcard-btn',
          on: 'bottom'
        },
        classes: 'shepherd example-step-extra-class',
        buttons: [{
            text: Lang.get("js.skip"),
            classes: 'shepherd-button-secondary',
            action: function() {
              $.ajax({
                url: route("update-steps", {
                  steps: 1
                }),
                type: "GET",
                success: function() {
                  tour.complete();
                }
              });
            }
          },
          {
            text: Lang.get("js.next"),
            action: function() {
              // Simulate clicking create button or navigate to create page
              localStorage.setItem('startFromStep13', 'true');
              window.location.href = '{{ route('vcards.create') }}';
            }
          }
        ]
      });
    }

    let hasSpecificStart = localStorage.getItem('startFromStep3') || localStorage.getItem('startFromStep6') ||
      localStorage.getItem('startFromStep11');
    if (!hasSpecificStart) {
      tour.start();
    }
    if (steps === 0 && hasActiveSub === true) {
      const startFromStep3 = localStorage.getItem('startFromStep3');
      if (startFromStep3 === 'true') {
        tour.start('step-3');
        localStorage.removeItem('startFromStep3');
      }

      const startFromStep6 = localStorage.getItem('startFromStep6');
      if (startFromStep6 === 'true') {
        tour.start('step-6');
        localStorage.removeItem('startFromStep6');
      }

      const startFromStep11 = localStorage.getItem('startFromStep11');
      if (startFromStep11 === 'true') {
        tour.start('step-11');
        localStorage.removeItem('startFromStep11');
      }
    }
  }
</script>

</script>
