<?php
namespace App\Controllers;
use Delight\Cookie\Cookie;
use Delight\Cookie\Session;
use Valitron\Validator;
use Medoo\Medoo;
use App\Utils\HeaderResponse;
use WebPConvert\WebPConvert;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Bcrypt\Bcrypt;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twig\Environment as Twig_Environment;


class TestController
{
	private $database;
    private $response;
    private $repository;
    private $twig;

    public function __construct(Medoo $database,HeaderResponse $response, Twig_Environment $twig)
    {
        $this->database = $database;
        $this->response = $response;        
        $this->twig = $twig;
    }

    public function home()
    {        
            $columns = [
                'id',
                'created_at',
                'name',
            ];

        $data=$this->database->select('profiles', $columns);
        echo $this->twig->render('home.twig', [
            'articles' => $data
        ]);
    }

    public function article($id)
    {        
        echo $this->twig->render('article.twig', [
            'article' => "Artikel ID ,".$id
        ]);
    }

	public function index()
    {            
        if (Cookie::exists('coba')) {
            $columns = [
                'id',
                'created_at',
                'name',
            ];

            $data=$this->database->select('profiles', $columns);
            echo $this->response->json_response(200, $data);   
        }else{
            echo "need cookie <a href='cookie'>set cookie </a>";
        }          
    }

   	public function cookie()   	
    {    	    	
        $cookie = new Cookie('coba');
        $cookie->setValue('cobacoba');
        // expired 24 jam
        $cookie->setMaxAge(60 * 60 * 24);
        //never expired        
        //$cookie->setMaxAge(time() + (10 * 365 * 24 * 60 * 60)); 
        $cookie->setPath('/');
        $cookie->setDomain('localhost');
        $cookie->setHttpOnly(true);
        //$cookie->setSecureOnly(true);
        $cookie->setSameSiteRestriction('Strict');
        echo $cookie;
        $cookie->save();
    }

    public function konversi()
    {
        $source = __DIR__ . '/../../storage/images/coba.jpg';
        $destination = __DIR__ . '/../../storage/images/coba.webp';
        $success = WebPConvert::convert($source, $destination, [
            //'converters' => ['cwebp']
            'converters' => ['gd']
        ]);
        echo "<img src='../storage/images/coba.webp'>";
    }

    public function create_token()
    {
       $time = time();
       $token = (new Builder())->issuedBy('https://localhost')
            ->permittedFor('https://localhost') 
            ->identifiedBy('4f1g23a12aa', true) 
            ->issuedAt($time)
            ->sign(new Sha256(),"kakek") 
            ->canOnlyBeUsedAfter($time) 
            ->expiresAt($time + 3600) 
            ->withClaim('uid',1) 
            ->getToken(); 
        echo $token;
    }

    public function validate_token(){
        $headers = apache_request_headers();
        $auth = $headers['Authorization'];
        if (preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
            $token = (new Parser())->parse((string) $matches[1]);
            $data = new ValidationData();
            $data->setIssuer('https://api.localhost');
            $data->setAudience('https://example.com');
            $data->setId('4f1g23a12aa');
            if ($token->validate($data)){                
                echo $this->response->json_response(200, "token berhasil validasi");
            }else{
                echo $this->response->json_response(200, "token tidak ter-validasi");                
            }

        }else{
            echo 'Header Tidak benar';
        }
    }

    public function post()
    {
        $v = new Validator($_POST);
        $v->rule('required', ['name', 'email']);
        $v->rule('email', 'email');
        if($v->validate()) {
            echo "Yay! We're all good!";
        } else {
            // Errors
            print_r($v->errors());
        }
    }

    public function password()
    {
        $bcrypt = new Bcrypt();
        //Encrypt the plaintext
        $plaintext = 'password';

        //Set the Bcrypt Version, default is '2y'
        $bcrypt_version = '2a';
        $ciphertext = $bcrypt->encrypt($plaintext,$bcrypt_version);
        print_r("\n Plaintext:".$plaintext);
        print_r("\n Ciphertext:".$ciphertext);
    }

    public function login()
    {
        $bcrypt = new Bcrypt();
        //Encrypt the plaintext
        $plaintext = 'password';
        //Set the Bcrypt Version, default is '2y'
        $bcrypt_version = '2a';
        $ciphertext = $bcrypt->encrypt($plaintext,$bcrypt_version);
        if($bcrypt->verify($_POST["password"], $ciphertext)){
            print_r("\n Password verified!");
        }else{
            print_r("\n Password not match!");
        }
    }

    public function Send_email()
    {
       
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = '53ddbad0bdb92b';                     // SMTP username
            $mail->Password   = '7bba11f98dcee8';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 2525;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('from@sempak.com', 'Mailer');
            $mail->addAddress('joe@sempak.net', 'Joe User');     // Add a recipient
            $mail->addAddress('ellen@sempak.com');               // Name is optional
            $mail->addReplyTo('info@sempak.com', 'Information');
            $mail->addCC('cc@sempak.com');
            $mail->addBCC('bcc@sempak.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Projek Telah Tedanai';
            $mail->Body    = 'Kalau Lapar <b>Yah Makan Broo</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

}