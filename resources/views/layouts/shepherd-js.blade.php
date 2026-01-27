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
          element: '.user-dashboard',
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
              localStorage.setItem('startFromStep2', 'true');
              window.location.href = '/admin/dashboard';
            }
          }
        ]
      });
    }

    // Step 2: Open sidebar on mobile (only on dashboard)
    tour.addStep({
      id: 'step-2',
      text: Lang.get("js.click_open_sidebar"),
      attachTo: {
        element: '.sidemenu-btn',
        on: 'bottom'
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
            $("#sidebar").addClass("collapsed-menu");
            $("body").addClass("collapsed-menu");
            tour.next();
          }
        }
      ]
    });

    // Step 3: Show Vcard on the side menu
    tour.addStep({
      id: 'step-3',
      text: Lang.get("js.show_vcard_sidebar"),
      attachTo: {
        element: '.vcard-option',
        on: 'bottom'
      },
      beforeShowPromise: function() {
        return new Promise(function(resolve) {
          if ($(window).width() < 1200) {
            $('html, body').animate({
              scrollTop: $('.vcard-option').offset().top - 100
            }, 500, function() {
              resolve();
            });
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
            tour.next();
          }
        }
      ]
    });

    // Step 4: Show RedirectLinks on the side menu
    tour.addStep({
      id: 'step-4',
      text: Lang.get("js.show_redirect_links_sidebar"),
      attachTo: {
        element: '.redirect-links-option',
        on: 'bottom'
      },
      beforeShowPromise: function() {
        return new Promise(function(resolve) {
          if ($(window).width() < 1200) {
            $('html, body').animate({
              scrollTop: $('.redirect-links-option').offset().top - 100
            }, 500, function() {
              resolve();
            });
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
            localStorage.setItem('startFromStep5', 'true');
            window.location.href = '{{ route('client.redirect-links.index') }}';
          }
        }
      ]
    });

    // Step 5: Show how to use redirect link code
    tour.addStep({
      id: 'step-5',
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
            $('#redeemModal').modal('show');
            setTimeout(() => tour.next(), 500);
          }
        }
      ]
    });

    // Step 6: Enter the redirect code
    tour.addStep({
      id: 'step-6',
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
            tour.next();
          }
        }
      ]
    });

    // Step 7: Save button
    tour.addStep({
      id: 'step-7',
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
            tour.next();
          }
        }
      ]
    });

    // Step 8: Close modal if no code
    tour.addStep({
      id: 'step-8',
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
            if (window.innerWidth < 1200) {
              tour.next();
            } else {
              tour.show('step-10');
            }
          }
        }
      ]
    });

    // Step 9: Open sidebar again
    tour.addStep({
      id: 'step-9',
      text: Lang.get("js.click_open_sidebar"),
      attachTo: {
        element: '.sidemenu-btn',
        on: 'bottom'
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
            $("#sidebar").addClass("collapsed-menu");
            $("body").addClass("collapsed-menu");
            tour.next();
          }
        }
      ]
    });

    // Step 10: Show vCard option and navigate
    tour.addStep({
      id: 'step-10',
      text: Lang.get("js.redeem_vcard_code"),
      attachTo: {
        element: '.vcard-option',
        on: 'bottom'
      },
      beforeShowPromise: function() {
        return new Promise(function(resolve) {
          if ($(window).width() < 1200) {
            $('html, body').animate({
              scrollTop: $('.vcard-option').offset().top - 100
            }, 500, function() {
              resolve();
            });
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
          action: function() {
            localStorage.setItem('startFromStep11', 'true');
            window.location.href = '{{ route('vcards.index') }}';
          }
        }
      ]
    });

    // Step 11: Create vCard button
    tour.addStep({
      id: 'step-11',
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

    tour.start();
    if (steps === 0 && hasActiveSub === true) {
      const startFromStep2 = localStorage.getItem('startFromStep2');
      if (startFromStep2 === 'true') {
        if (window.innerWidth < 1200) {
          tour.show('step-2');
        } else {
          tour.show('step-3');
        }
        localStorage.removeItem('startFromStep2');
      }

      const startFromStep5 = localStorage.getItem('startFromStep5');
      if (startFromStep5 === 'true') {
        tour.show('step-5');
        localStorage.removeItem('startFromStep5');
      }

      const startFromStep11 = localStorage.getItem('startFromStep11');
      if (startFromStep11 === 'true') {
        tour.show('step-11');
        localStorage.removeItem('startFromStep11');
      }
    }
  }
</script>
