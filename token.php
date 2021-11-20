<?php
date_default_timezone_set('Asia/Jakarta');
require_once(dirname(__FILE__) . '/vendor/autoload.php');


$colors = new \Colors();
use Curl\Curl;
echo '['.$colors->getColoredString(date('H:i:s'), 'green').'] | [?] Discord get token account'.PHP_EOL;
    echo '['.$colors->getColoredString(date('H:i:s'), 'green').'] | [?] Email: ';
    $email = trim(fgets(STDIN));
    echo '['.$colors->getColoredString(date('H:i:s'), 'green').'] | [?] Password: ';
    $password = trim(fgets(STDIN));
    $curl = new Curl();
    $curl->setHeader('Host', 'discord.com');
    $curl->setHeader('authorization', 'undefined');
    $curl->setHeader('Content-Type', 'application/json');
    $curl->post('https://discord.com/api/v9/auth/login', [
        'login' => $email,
        'password' => $password,
        'undelete' => false,
        'captcha_key' => null,
        'login_source' => null,
        'gift_code_sku_id' => null,
            ]);
    if ($curl->error) {
        die('['.$colors->getColoredString(date('H:i:s'), 'green').'] | [!] Login Failed!!'.error.''.PHP_EOL);
    } else {
        echo '['.$colors->getColoredString(date('H:i:s'), 'green').'] | [!] Login Success, Your Token '. $curl->response->token.' Saved in File token.json'.PHP_EOL;
        if(!file_exists("token.json")) {
            file_put_contents("token.json", json_encode([
                'email' => $email,
                'password' => $password,
                'Authorization' => $curl->response->token,
            ]));
            }   
        }


class Colors {
    private $foreground_colors = array();
      private $background_colors = array();
  
      public function __construct() {
          // Set up shell colors
          $this->foreground_colors['black'] = '0;30';
          $this->foreground_colors['dark_gray'] = '1;30';
          $this->foreground_colors['blue'] = '0;34';
          $this->foreground_colors['light_blue'] = '1;34';
          $this->foreground_colors['green'] = '0;32';
          $this->foreground_colors['light_green'] = '1;32';
          $this->foreground_colors['cyan'] = '0;36';
          $this->foreground_colors['light_cyan'] = '1;36';
          $this->foreground_colors['red'] = '0;31';
          $this->foreground_colors['light_red'] = '1;31';
          $this->foreground_colors['purple'] = '0;35';
          $this->foreground_colors['light_purple'] = '1;35';
          $this->foreground_colors['brown'] = '0;33';
          $this->foreground_colors['yellow'] = '1;33';
          $this->foreground_colors['light_gray'] = '0;37';
          $this->foreground_colors['white'] = '1;37';
  
          $this->background_colors['black'] = '40';
          $this->background_colors['red'] = '41';
          $this->background_colors['green'] = '42';
          $this->background_colors['yellow'] = '43';
          $this->background_colors['blue'] = '44';
          $this->background_colors['magenta'] = '45';
          $this->background_colors['cyan'] = '46';
          $this->background_colors['light_gray'] = '47';
      }
  
      // Returns colored string
      public function getColoredString($string, $foreground_color = null, $background_color = null) {
          $colored_string = "";
  
          // Check if given foreground color found
          if (isset($this->foreground_colors[$foreground_color])) {
              $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
          }
          // Check if given background color found
          if (isset($this->background_colors[$background_color])) {
              $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
          }
  
          // Add string and end coloring
          $colored_string .=  $string . "\033[0m";
  
          return $colored_string;
      }
  
      // Returns all foreground color names
      public function getForegroundColors() {
          return array_keys($this->foreground_colors);
      }
  
      // Returns all background color names
      public function getBackgroundColors() {
          return array_keys($this->background_colors);
      }
  }
