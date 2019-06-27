<?php

function register_menu()
{
  add_menu_page(
    'Main Plugin',
    'Main Plugin',
    'manage_options',
    'main-plugin'
  );
}

add_action('admin_menu', 'register_menu');
