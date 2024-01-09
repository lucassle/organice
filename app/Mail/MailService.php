<?php
    namespace App\Mail;

    use App\Models\SettingModel;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Mail;

    class MailService {
        private $fromTitle;

        public function __construct() {
            $this->fromTitle = 'Organice';
        }

        public function sendContactConfirm ($data) {
            $mail   = json_decode(SettingModel::where('key_value', 'setting-email-account')->first()->value, true);
            if (empty($mail))
                return false;
            else {
                Mail::send([], [], function ($message) use ($mail, $data) {
                    $message->from($mail['username'], $this->fromTitle);
                    $message->to($data['email']);
                    $message->subject($this->fromTitle, 'Notification of successful contact sending!');

                    $content    = sprintf('
                    <p>Hello, %s,</p>
                    <p>We have received your contact information and will respond as soon as possible!</p>
                    <p>Thanks for your attention!</p>
                    ', $data['name']);
                    $message->setBody($content, 'text/html');
                });
                return true;
            }
        }

        public function sendContactInfo ($data) {
            $mail   = json_decode(SettingModel::where('key_value', 'setting-email-account')->first()->value, true);
            if (empty($mail))
                return false;
            else {
                Mail::send([], [], function ($message) use ($mail, $data) {
                    $message->from($mail['username'], $this->fromTitle);
                    $bcc = explode(',', SettingModel::where('key_value', 'setting-email-bcc')->first()->value);
                    $message->bcc($bcc);
                    $message->subject('Contact Information form ' . $data['name']);
                    $content    = sprintf('
                    <p>Name: %s</p>
                    <p>Email: %s</p>
                    <p>Phone: %s</p>
                    <p>Message: %s</p>
                    ', $data['name'], $data['email'], $data['phone'], $data['message']);
                    $message->setBody($content, 'text/html');
                });
                return true;
            }
        }
    }