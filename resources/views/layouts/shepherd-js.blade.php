<script>
  var steps = {{ getLogInUser()->steps }};
  var hasActiveSub = {{ json_encode(hasActiveSubscription()) }};

  if (steps == 0 && hasActiveSub == true) {
    let redirectLinksUrl = '{{ route('client.redirect-links.index') }}';

    if (window.location.pathname !== new URL(redirectLinksUrl).pathname) {
      window.location.href = redirectLinksUrl;
    } else {
      const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
          classes: 'shadow-md bg-purple-dark',
          scrollTo: true
        }
      });

      tour.addStep({
        id: 'step-1',
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
    }
  }
</script>
