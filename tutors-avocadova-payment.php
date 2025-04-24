<?php
/*
Plugin Name: Avocadova Tutors Payment System
Description: Let users top up tutoring hours via QuickBooks.
Version: 1.0
Author: Jesrel Agang
*/

add_shortcode('tutor_topup_form', 'tutor_topup_display_form');

function tutor_topup_display_form() {
    ob_start();
    ?>

    <!-- Bootstrap CSS (include only if your theme doesn't already) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Top Up Button -->
    <button class="btn btn-primary" id="topupBtn">Top Up</button>

    <!-- Modal -->
    <div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="topupModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="topupModalLabel">Top Up</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label for="durationSelect" class="form-label">Choose Duration</label>
            <select class="form-select mb-3" id="durationSelect">
              <!-- Options populated by JavaScript -->
            </select>
            <div id="details" class="border rounded p-3 bg-light">
              <!-- Session details will show here -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Session Options and Script -->
    <script>
      const options = [
      { hours: "0.50", price: 6, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-9cc5b402bb714a1fa69c5db6d803e3e3177692e39f8a41c9947efa878aa969aebf92311afa734a2e9a92fdbe39fd449b?locale=EN_US" },
      { hours: "1.00", price: 12, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-649faf051ba644eaa21b8d48d723b77d8710ae01205243e695aef1863b253741ff188326a8c14f688d31043cfb2f5980?locale=EN_US" },
      { hours: "1.50", price: 18, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-be1957e72bf2460b94fd183285928b3409e018e30a354b389a5a84d71a4d1ccb88fe8ba8af284c2c87cb28f6cdb9de69?locale=EN_US" },
      { hours: "2.00", price: 24, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-85463c268a7c4f5d936c567924ab30eaf46c7494ea0f440a8ba451d7c3dd2ee3aacdd5e1e0664c5183cfdff780925bb6?locale=EN_US" },
      { hours: "2.50", price: 30, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-eb04e9933e204a4998d7eecce1021fb8c7baea09c16a4906892a381517e4078d0c1df12f67fa46b78ceaf64bf386790e?locale=EN_US" },
      { hours: "3.00", price: 36, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-f380a6f4313e42e3b411396f7c08f400acd100e4b82d48b08f594b8d98e56463845cf0b66d4f4ead85dbc897713a1b5d?locale=EN_US" },
      { hours: "3.50", price: 42, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-8b375fd2e282423db5321ccb849c953b7faf71d052b44a969ac87b48957d042e4d1763be996947189fc63e52b6893aec?locale=EN_US" },
      { hours: "4.00", price: 48, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-069dfff2fd6e47e5bd27105991c8fdc05d969a59333a4af6898ed81d8a08ff6158e13527bb884e768a39fda519a7eb96?locale=EN_US" },
      { hours: "4.50", price: 54, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-69e7d5b36c9045f8ba7458e8814bc3c3b4f3b47755f340c8b67bb15bd7494a1f89080d36f21648459a6d8943a09201d4?locale=EN_US" },
      { hours: "5.00", price: 60, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-6297b4b01c7d460f858f7e1e0949231b1e39729fd4924604a2a8b4a5655f2367cc2a216eef524eedb34bc456dde3b597?locale=EN_US" },
      { hours: "6.00", price: 72, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-ed0bd803479f4fd5bb66d31365bfe08c6c33987df58b437181a81bc61713fc31670b9102b7da4546ada9508da52a0c80?locale=EN_US" },
      { hours: "7.00", price: 84, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-8010a321235e49119637095daa76450a420903c090df48ca84715ee092bc71c889dfc8130ea04bca84acb8d749993401?locale=EN_US" },
      { hours: "8.00", price: 96, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-d32b0a0cf2a844dba7e432f3920dd171ef5f1e1c9fb94c9bb7a3020b83cedf00c86409c3649947aebdff67393897ec42?locale=EN_US" },
      { hours: "9.00", price: 108, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-86402a0c666a4647a574e11c8ad7917ba82dd2d8c75845e9a37bd8400e4db237b18f09a8513147db84e19e679805dd26?locale=EN_US" },
      { hours: "10.00", price: 120, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-93566e762fd446ed9c63c24c10b4a9fe5ca02367849a4b73885897dc9b4a1d9bc102c593344046728649fd17ead9304a?locale=EN_US" },
      { hours: "20.00", price: 240, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-360fa4542d46486e8fc510f07057b729f8f7dd359dda4001ad6b117ed2f003f04d4244d52d5e40e7b44cea3a2b36a4f7?locale=EN_US" },
      { hours: "30.00", price: 360, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-92176ddadeb24e74b153335d22839c3cd34266a7d4764679ab20722709c3aa3b37adfa6bf1134bb886a5969cf57473b2?locale=EN_US" },
      { hours: "40.00", price: 480, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-3e82d6704cf541c7961e4925a8db82691aa658b2c267474da7d2e5f4ae744f3bded35bc980e04349aa723ff95fd99fff?locale=EN_US" },
      { hours: "50.00", price: 600, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-a57660385e92439ead3dc4dea34580e08b0a3c86505e49c0ac6b883be2209ee95d9b6ab0ec154fe2bd7aa62a72e4aa90?locale=EN_US" },
      { hours: "60.00", price: 720, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-638481670baf41688e5e900ec0e32f419cd4ffbc1f3d4b4d83b45f8b65ac6dc36a051057ab4c4433ab44dd1cc0cac62a?locale=EN_US" },
      { hours: "70.00", price: 840, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-9f061667d98d43928f9f94e399cd7dbf2a4aa5d69cd54e188d1b6f4080c3e0fa31e36cbb7e5b492e866dd7e33204a778?locale=EN_US" },
      { hours: "80.00", price: 960, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-99bd01a3aac343a1b43ea46a9d9266a7512ea7ffb2984fb18fd35a65a2db68144afc20bc40954a57aacf8bea46be42a0?locale=EN_US" },
      { hours: "90.00", price: 1080, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-44acff2650a34408a3ce75b2c4883c8cca4e7a9bf6c4444db5049ed15898f75965cf07d0e98f438aa7d6bc615b6a87d9?locale=EN_US" },
      { hours: "100.00", price: 1200, link: "https://connect.intuit.com/portal/app/CommerceNetwork/view/scs-v1-eed0cb5dc28e454c966b766cdec4feb8914e323d66d44d4dbc1950fd3695ad9c554d5ecf94e24cd2a3c558f37bdb1d4a?locale=EN_US" }
      ];


      document.addEventListener("DOMContentLoaded", function () {
        const topupBtn = document.getElementById("topupBtn");
        const durationSelect = document.getElementById("durationSelect");
        const details = document.getElementById("details");

        // Populate dropdown
        options.forEach(opt => {
          const option = document.createElement("option");
          option.value = opt.hours;
          option.textContent = `${opt.hours} Hour${opt.hours !== "1.0" ? "s" : ""} - $${opt.price}`;
          durationSelect.appendChild(option);
        });

        function updateDetails() {
          const selected = options.find(opt => opt.hours === durationSelect.value);
          if (selected) {
            details.innerHTML = `
              <h6>${selected.hours} Hour${selected.hours !== "1.0" ? "s" : ""} - Online Tutor | Avocado VA</h6>
              <p><strong>Duration:</strong> ${selected.hours} Hour${selected.hours !== "1.0" ? "s" : ""}</p>
              <p><strong>Price:</strong> $${selected.price}</p>
              <a class="btn btn-success" target="_blank" href="${selected.link}">Proceed to Payment</a>
            `;
          }
        }

        durationSelect.onchange = updateDetails;

        topupBtn.addEventListener("click", () => {
          const modal = new bootstrap.Modal(document.getElementById('topupModal'));
          modal.show();
          updateDetails();
        });
      });
    </script>

    <?php
    return ob_get_clean();
}

//This is for the callback URL from QuickBooks. You can uncomment and modify it as needed.
// // Add a custom query variable for the callback URL
// add_action('init', function() {
//    add_rewrite_rule('^tutor-credit-callback/?', 'index.php?tutor_credit_callback=1', 'top');
//    add_rewrite_tag('%tutor_credit_callback%', '1');
// });

// // Handle the callback from QuickBooks
// // This function will be called when QuickBooks redirects back to your site
// add_action('template_redirect', function() {
//    if (get_query_var('tutor_credit_callback') !== '1') return;

//    $user_id = get_current_user_id(); // You may get this from a token or GET param
//    $credit_hours = floatval($_GET['hours'] ?? 0);

//    if ($user_id && $credit_hours > 0) {
//        $existing = floatval(get_user_meta($user_id, 'tutor_credits', true));
//        update_user_meta($user_id, 'tutor_credits', $existing + $credit_hours);
//        wp_redirect(home_url('/thank-you'));
//        exit;
//    }

//    wp_die('Invalid request.');
// });


add_action('rest_api_init', function () {
   register_rest_route('tutor/v1', '/credit', [
     'methods' => 'POST',
     'callback' => 'tutor_add_credit',
     'permission_callback' => '__return_true',
   ]);
 });
 
 function tutor_add_credit($request) {
   $token = $request->get_param('token');
   $expected_token = 'HyqsHqJgivQjQT7hkaMu1FXEKi6FJq75'; // Replace this with your actual secret
 
   if ($token !== $expected_token) {
     return new WP_Error('unauthorized', 'Invalid token', ['status' => 403]);
   }
 
   $user_id = intval($request->get_param('user_id'));
   $hours = floatval($request->get_param('hours'));
 
   if (!$user_id || !$hours) {
     return new WP_Error('invalid_data', 'Missing user or hours', ['status' => 400]);
   }
 
   $current = floatval(get_user_meta($user_id, 'tutor_credits', true));
   update_user_meta($user_id, 'tutor_credits', $current + $hours);
 
   return [
     'status' => 'success',
     'new_balance' => $current + $hours
   ];
 }
 
 


//-----------------------------------------------------------//
// Add a shortcode to display the user's current credit balance
// This will show the current balance of the logged-in user
add_shortcode('tutor_credit_balance', function() {
   if (!is_user_logged_in()) {
       return "Please log in to view your tutoring credits.";
   }
   $user_id = get_current_user_id();
   $credits = get_user_meta($user_id, 'tutor_credits', true);
   $credits = $credits ? floatval($credits) : 0;

   return "<p><strong>Your Current Credit:</strong> {$credits} hour(s)</p>";
});


add_shortcode('book_tutor_session', 'tutor_booking_form');
function tutor_booking_form() {
    if (!is_user_logged_in()) {
        return "Please log in to book a tutoring session.";
    }

    if (isset($_POST['session_hours'])) {
        $hours = floatval($_POST['session_hours']);
        $user_id = get_current_user_id();
        $current = floatval(get_user_meta($user_id, 'tutor_credits', true));

        if ($hours <= $current) {
            $new_balance = $current - $hours;
            update_user_meta($user_id, 'tutor_credits', $new_balance);

            return "<p><strong>Booking Confirmed!</strong> {$hours} hour(s) deducted. New balance: {$new_balance} hour(s).</p>";
        } else {
            return "<p><strong>Not enough credits!</strong> You have {$current} hour(s).</p>";
        }
    }

    // Display the booking form
      // This is a simple form for selecting session duration
    ob_start(); ?>
    <form method="post">
        <label>Session Duration:</label>
        <select name="session_hours" required>
            <option value="0.5">0.5 Hour</option>
            <option value="1.0">1.0 Hour</option>
            <option value="1.5">1.5 Hours</option>
        </select><br><br>
        <input type="submit" value="Book Session">
    </form>
    <?php return ob_get_clean();
}

// Add a custom endpoint to handle the webhook from QuickBooks
add_action('rest_api_init', function () {
   register_rest_route('tutor/v1', '/credit-user', [
       'methods' => 'POST',
       'callback' => 'tutor_webhook_credit_user',
       'permission_callback' => '__return_true' // You can add auth later
   ]);
});

// This function will be called when QuickBooks sends a webhook to the endpoint
function tutor_webhook_credit_user($request) {
   $params = $request->get_json_params();
   $email = sanitize_email($params['email'] ?? '');
   $hours = floatval($params['hours'] ?? 0);

   if (!$email || !$hours) return new WP_REST_Response(['error' => 'Missing data'], 400);

   $user = get_user_by('email', $email);
   if (!$user) return new WP_REST_Response(['error' => 'User not found'], 404);

   $existing = floatval(get_user_meta($user->ID, 'tutor_credits', true));
   update_user_meta($user->ID, 'tutor_credits', $existing + $hours);

   return new WP_REST_Response(['success' => true, 'new_balance' => $existing + $hours], 200);
}


