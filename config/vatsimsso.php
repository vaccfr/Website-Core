<?php

return [
  'fr_client_id' => env('FR_VATSIM_SSO_ID'),
  'fr_secret' => env('FR_VATSIM_SSO_SECRET'),
  'fr_redirect' => env('FR_VATSIM_SSO_RETURN'),
  'en_client_id' => env('EN_VATSIM_SSO_ID'),
  'en_secret' => env('EN_VATSIM_SSO_SECRET'),
  'en_redirect' => env('EN_VATSIM_SSO_RETURN'),
  'url' => env('VATSIM_SSO_URL'),
  'token_url' => env('VATSIM_SSO_TOKEN_URL'),
];