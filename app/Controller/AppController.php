<?php
App::uses('Controller', 'Controller');
/**
 * Application Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class AppController extends Controller {
    public $helpers = array('Html', 'Form', 'Session', 'Assets');
    public $viewClass = 'TwigView.Twig';
    public $uses = array('Job');
    public $components = array(
        'Auth' => array(
            'authenticate' => array('Form'),
            'authError' => "Sorry, you'll need to login to do that."
        ),
        'Session',
        'RequestHandler',
        'Access'
    );

    public function beforeFilter() {


        // code to pull the projects from kora for the header - here because every page needs it

        $user = "";
        $pass = "";
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PROJECT_SID."&token=".TOKEN."&display=json";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        $out = json_decode(curl_exec($ch), true);
        $projects = array();
        foreach($out as $item) {
            array_push($projects, $item);
        }
        if (substr($this->request->url, 0, 3) == 'api')
            $this->Auth->authenticate = array('Basic');




        $this->set(array(
            'user' => array(
                'loggedIn' => $this->Auth->loggedIn(),
                'id' => $this->Auth->user('id'),
                'name' => $this->Auth->user('name'),
                'email' => $this->Auth->user('email'),
                'role' => $this->Auth->loggedIn() ?
                    $this->Auth->user('role') : "Researcher",
                'username' => $this->Auth->user('username'),
                'gravatar' => md5(strtolower($this->Auth->user('email')))
            ),
            'toolbar' => array(
                'logo' => true,
                'buttons' => array()
            ),
            'body_class' => 'default',
            'footer' => true,
            'debug' => Configure::read('debug'),
            'projects' => $projects
        ));

        $this->RequestHandler->addInputType('json', array('json_decode', true));


    }

    /**
     * Convenience method for multiple Request->is($type) checks.
     *
     * @param  string $args   One or more request types to check.
     * @return bool           True if *all* checks pass.
     */
    public function requestIs($args) {
        $checks = func_get_args();
        foreach($checks as $check)
            if (!$this->request->is($check)) return false;
        return true;
    }

    public function baseURL() {
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->base;
    }

    /**
     * Convenience method for wrapping up JSON response logic.
     *
     * Sets the response content header to 'application/json', sets the given
     * HTTP status code (or 200, if not given), and delivers the (possibly
     * empty) payload.
     *
     * @param  int $status      HTTP status code to set, 200 (OK) by default.
     * @param  mixed $data      Payload to deliver, is coerced to an array.
     * @return void
     */
    public function json($status=200, $data=null) {
        $this->autoRender = false;
        $this->response->statusCode($status);
        $this->RequestHandler->respondAs('json');
        # JSON_NUMERIC_CHECK was added in 5.3.3. It ensures numbers are encoded
        # as numbers. We use it if available.
        if (defined('JSON_NUMERIC_CHECK'))
            $this->response->body(json_encode((array)$data, JSON_NUMERIC_CHECK));
        else
            $this->response->body(json_encode((array)$data));
    }


    // So I don't know if this is the best place to put it, but unfortunately the thumbnail code is needed by both
    // the resource controller and the search controller, and calling anything from the resource controller from the
    // search controller or vice versa appears to cause an error

    /**
     * Get a small thumb of a resource (240x200), will create thumb if it doesn't already exist
     *
     * @param string $name should be name of image file
     *
     * @return string the url to the thumb
     */
    public static function smallThumb($name) {
        $path = THUMBS . "smallThumbs/";
        $thumb = pathinfo($name, PATHINFO_FILENAME) . ".jpg";
        $path .= $thumb;
        $url = THUMBS_URL . "smallThumbs/" . $thumb;
        if(!file_exists($path)) {
            $imgpath = KORA_FILES_URI . "/" . PID . "/" . PAGES_SID . "/" . $name;
            $image = imagecreatefromstring(file_get_contents($imgpath));
            $result = AppController::resize($image, 240, 200);
            imagedestroy($image);
            imagejpeg($result, $path);
            imagedestroy($result);
        }
        return $url;
    }

    /**
     * Get a large thumb of a resource (400x400), will create thumb if it doesn't already exist
     *
     * @param string $name should be name of image file
     *
     * @return string the url to the thumb
     */
    public function largeThumb($name) {
        $path = THUMBS . "largeThumbs/";
        $thumb = pathinfo($name, PATHINFO_FILENAME) . ".jpg";
        $path .= $thumb;
        $url = THUMBS_URL . "largeThumbs/" . $thumb;
        if(!file_exists($path)) {
            $imgpath = KORA_FILES_URI . "/" . PID . "/" . PAGES_SID . "/" . $name;
            $image = imagecreatefromstring(file_get_contents($imgpath));
            $result = $this->resize($image, 400, 400);
            imagedestroy($image);
            imagejpeg($result, $path);
            imagedestroy($result);
        }
        return $url;
    }


    /**
     * Used by smallThumb and largeThumb to do the resizing work - I think this should work...
     * @param $image
     * @param $min_width
     * @param $min_height
     * @param string $method
     * @return resource
     */
    private static function resize($image, $min_width, $min_height, $method = 'scale')
    {
        // get the current dimensions of the image
        $src_width = imagesx($image);
        $src_height = imagesy($image);

        // if either max_width or max_height are 0 or null then calculate it proportionally
        if( !$min_width ){
            $min_width = $src_width / ($src_height / $min_height);
        }
        elseif( !$min_height ){
            $min_height = $src_height / ($src_width / $min_width);
        }

        // if scaling the image calculate the dest width and height
        $dx = $src_width / $min_width;
        $dy = $src_height / $min_height;
        /*if( $method == 'scale' ){
            $d = max($dx,$dy);
        }
        // otherwise assume cropping image
        else{
            $d = min($dx, $dy);
        }*/
        $d = min($dx, $dy);
        $new_width = $src_width / $d;
        $new_height = $src_height / $d;
        // sanity check to make sure neither is zero
        $new_width = max(1,$new_width);
        $new_height = max(1,$new_height);

        $thumb_width = max($min_width, $new_width);
        $thumb_height = max($min_height, $new_height);

        // offset into thumbination image
        $thumb_x = ($thumb_width - $new_width) / 2;
        $thumb_y = ($thumb_height - $new_height) / 2;

        // create a new image to hold the thumbnail
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

        // copy from the source to the thumbnail
        imagecopyresampled($thumb, $image, $thumb_x, $thumb_y, 0, 0, $new_width, $new_height, $src_width, $src_height);
        return $thumb;
    }
}
