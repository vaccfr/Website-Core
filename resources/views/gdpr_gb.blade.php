<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>GDPR Data {{$userData->vatsim_id}}</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </head>
  <style>
  .page-break {
      page-break-after: always;
  }
  </style>
  <body>
    <h3>Personal Information</h3>
    <h5>Generated for {{ Auth::user()->fname }} {{ Auth::user()->lname }} (CID: {{ Auth::user()->vatsim_id }}) | {{ Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s') }}</h5>
    <p>This section includes your user data, user settings, email preferences and Discord Data. <br><i>For security reasons, some data elements might be censored or omitted. Please contact us for any questions</i></p>
    <h5>User Data</h5>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">User ID</th>
          <th scope="col">CID</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Email</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>{{substr($userSettings->id, 0, 5)}}<b>*************</b></td>
              <td>{{$userData->vatsim_id}}</td>
              <td>{{$userData->fname}}</td>
              <td>{{$userData->lname}}</td>
              <td>{{$userData->email}}</td>
          </tr>
      </tbody>
    </table>
    <hr>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">Registration Date</th>
          <th scope="col">Custom Email</th>
          <th scope="col">Account Type</th>
          <th scope="col">ATC status</th>
          <th>ATC Rating</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>{{$userData->created_at}}</td>
              <td>@if (is_null($userData->custom_email)) (None) @else {{$userData->custom_email}} @endif</td>
              <td>{{$userData->account_type}}</td>
              <td>@if ($userData->is_approved_atc == true) Yes @else No @endif</td>
              <td>{{$userData->atc_rating_short}}</td>
          </tr>
      </tbody>
    </table>
    <hr>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">Pilot Rating</th>
          <th scope="col">Division</th>
          <th scope="col">Region</th>
          <th scope="col">Sub Division</th>
          <th>Staff</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>P{{$userData->pilot_rating}}</td>
              <td>{{$userData->division_id}} {{$userData->division_name}}</td>
              <td>{{$userData->region_id}} {{$userData->region_name}}</td>
              <td>{{$userData->subdiv_id}} {{$userData->subdiv_name}}</td>
              <td>@if ($userData->is_staff == true) Yes @else No @endif</td>
          </tr>
      </tbody>
    </table>
    <hr>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">Linked Discord</th>
          <th scope="col">Privacy on Details</th>
          <th scope="col">Last Login Date</th>
          <th scope="col">Last Login IP</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>@if ($userData->linked_discord == true) Yes @else No @endif</td>
              <td>@if ($userData->hide_details == true) Yes @else No @endif</td>
              <td>{{$userData->last_login}}</td>
              <td>{{$userData->login_ip}}</td>
          </tr>
      </tbody>
    </table>
    <hr>
    <h5>User Settings</h5>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">User ID</th>
          <th scope="col">Vatsim ID</th>
          <th scope="col">Preferred Language</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>{{substr($userSettings->id, 0, 5)}}<b>*************</b></td>
              <td>{{$userSettings->vatsim_id}}</td>
              <td>{{$userSettings->lang}}</td>
          </tr>
      </tbody>
    </table>
    <hr>
    <h5>User Email Preferences</h5>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">Event Emails</th>
          <th scope="col">ATC Booking Emails</th>
          <th scope="col">ATC Mentoring Emails</th>
          <th scope="col">Website Update Emails</th>
          <th scope="col">News Emails</th>
          <th>Messenger Emails</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>@if ($userData->event_emails == true) Yes @else No @endif</td>
              <td>@if ($userData->atc_booking_emails == true) Yes @else No @endif</td>
              <td>@if ($userData->atc_mentoring_emails == true) Yes @else No @endif</td>
              <td>@if ($userData->website_update_emails == true) Yes @else No @endif</td>
              <td>@if ($userData->news_emails == true) Yes @else No @endif</td>
              <td>@if ($userData->internal_messaging_emails == true) Yes @else No @endif</td>
          </tr>
      </tbody>
    </table>
    <h5>Discord Data</h5>
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">Discord ID</th>
          <th scope="col">Username</th>
          <th scope="col">Ban status</th>
          <th scope="col">SSO Code</th>
          <th scope="col">SSO Token 1</th>
          <th>SSO Token 2</th>
        </tr>
      </thead>
      <tbody>
          <tr>
              <td>{{$userDiscord->discord_id}}</td>
              <td>{{$userDiscord->username}}</td>
              <td>@if ($userDiscord->banned == true) Yes @else No @endif</td>
              <td>{{substr($userDiscord->sso_code, 0, 5)}}<b>*****</b></td>
              <td>{{substr($userDiscord->sso_access_token, 0, 5)}}<b>*****</b></td>
              <td>{{substr($userDiscord->sso_refresh_token, 0, 5)}}<b>*****</b></td>
          </tr>
      </tbody>
    </table>
    <div class="page-break"></div>
    <h3>ATC Related Data</h3>
    <h5>Generated for {{ Auth::user()->fname }} {{ Auth::user()->lname }} (CID: {{ Auth::user()->vatsim_id }}) | {{ Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s') }}</h5>
    <p>This section includes all controller data related to your account. <br><i>For security reasons, some data elements might be censored or omitted. Please contact us for any questions</i></p>
    <h5>ATC Bookings</h5>
    @if (is_null($atcBookings))
      <p><i>No ATC Bookings Found</i></p>
    @else
    <table class="table table-striped" style="text-align: center;">
      <thead>
        <tr>
          <th scope="col">Position</th>
          <th scope="col">Date</th>
          <th>Training</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($atcBookings as $atcb)
          <tr>
            <td>{{$atcb['position']}}</td>
            <td>{{$atcb['date']}} {{$atcb['time']}}</td>
            <td>@if ($atcb['training'] == true) Yes @else No @endif</td>
          </tr>
          @endforeach
      </tbody>
    </table>
    @endif
  </body>
</html>