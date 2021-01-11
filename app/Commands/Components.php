<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Components extends BaseCommand
{

    protected $group       = 'Steigenberg';
    protected $name        = 'create-component';
    protected $description = 'Creates component with its view and route.
    Example: php spark create-component {MODULE SLUG} {COMPONENT SLUG}
    {MODULE SLUG}    : Module slug name of which component is being created.
    {COMPONENT SLUG} : Unique slug for the component. Which will later become <name/>
    {Title}          : Title for the Component';

    protected $folders = [
        "Components",
    ];

    protected $files = [
        "Config/routes.json",
        "Config/Routes.php",
        "Views/view_{sanitized_title}.php",
        "Components/{slug}.js"
    ];

    private function getModules()
    {
        $system_modules = ROOTPATH . "stigniter/system/system-modules/";
        $public_modules = ROOTPATH . "stigniter/modules/";

        $modules = [];
        $components = [];

        foreach (scandir($system_modules) as $index => $m) {
            if ($index > 1) {
                $modules[] = $m;
                /* Components */
                $components_path = $system_modules . $m . "/Components/";

                foreach (scandir($components_path) as $ind => $c) {
                    if ($ind > 1) {
                        $c = str_replace(".js", "", $c);
                        $components[] = strtolower($c);
                    }
                }
            }
        }

        foreach (scandir($public_modules) as $index => $m) {
            if ($index > 1) {
                $modules[] = $m;
                /* Components */
                $components_path = $public_modules . $m . "/Components/";

                foreach (scandir($components_path) as $ind => $c) {
                    if ($ind > 1) {
                        $c = str_replace(".js", "", $c);
                        $components[] = strtolower($c);
                    }
                }
            }
        }



        return [
            "components" => $components,
            "modules"    => $modules
        ];
    }

    private function createComponent($config = [])
    {
        if (empty($config)) return false;

        /* Lets Make A Module */
        $system_path = ROOTPATH . "stigniter/system/system-modules/";
        $public_path = ROOTPATH . "stigniter/modules/";
        
        $path = (file_exists($public_path.$this->slug)) ? $public_path : $system_path;
        
        $full_path = $path . $this->slug;
        
            $module_type = (file_exists($public_path.$this->slug)) ? "Modules" : "SystemModules";

            $this->template_variables = [
                "module-path" => $full_path,
                "module-type" => $module_type,
                "slug"        => $this->slug,
                "sanitized_title" => $this->title,
                "path"        => $this->slug."/".$this->component_slug,
                "title"       => $this->title,
                "component_name" => $this->component_slug,
                "controller_psr4" => "\\".$module_type. "\\$this->slug\\Controllers\\$this->title::index"
            ];


            
            /* Create Route */
            $routes = $this->getRoutes( $full_path );

            $r = $this->slug.'/'.$this->component_slug;

            foreach($routes['ci'] as $cir):
                if($cir['route'] == $r){
                    CLI::write('Error Occured: ' . CLI::color("CI ROUTE ALREADY EXISTS ON THIS PATH : $r", 'red'));
                    die;
                }
            endforeach;
            $routes['ci'][] = [
                "method" => "get",
                "route"  => $r,
                "class"  => $this->template_variables['controller_psr4']
            ];

            $routes_output = "<?php\n";

            foreach($routes['ci'] as $rc){
                $routes_output .= "\$routes->".trim( $rc['method'] )."('".trim($rc['route'])."', '".trim($rc['class'])."');\n";
            }

            foreach($routes['angular'] as $ar){
                if($ar['path'] == "/".$r){
                    CLI::write('Error Occured: ' . CLI::color("ANGULAR ROUTE ALREADY EXISTS ON THIS PATH : $r", 'red'));
                    die;
                }
            }

            $routes['angular'][] = [
                "path" => "/".$r,
                "template" => "<$this->component_slug/>"
            ];
            /* Route Created */


            /* Create Controller */
            $template_ctrl = file_get_contents( __DIR__."/files-template/Controllers.php" );

            foreach($this->template_variables as $index => $val)
                $template_ctrl = str_replace("{".$index."}", $val, $template_ctrl);
                $ctrl_path = $full_path."/Controllers/{$this->title}.php";
                
                if(file_exists($ctrl_path)){
                    CLI::write('Error Occured: ' . CLI::color("Controller already exists by name : $this->title ", 'red'));
                die;
                }
            /* Controller Created */

            /* Create Component */
            $template_component = file_get_contents( __DIR__."/files-template/Component.js" );

            foreach($this->template_variables as $index => $val)
                $template_component = str_replace("{".$index."}", $val, $template_component);
            /* Component Created */


            /* Create View File */
            $template_view = file_get_contents( __DIR__."/files-template/view.php" );

            foreach($this->template_variables as $index => $val)
                $template_view = str_replace("{".$index."}", $val, $template_view);
            /* View File Create */

            file_put_contents($full_path."/Config/Routes.php", $routes_output);
            file_put_contents($full_path."/Config/routes.json", json_encode($routes['angular']));
            file_put_contents($ctrl_path, $template_ctrl);
            file_put_contents($full_path."/Components/{$this->component_slug}.js", $template_component);
            file_put_contents($full_path."/Views/view_{$this->title}.php", $template_view);
            
            return true;
    }


    private function getRoutes($module_path = false){
        if(!$module_path) return false;
        $angular_routes = $module_path."/Config/routes.json";
        $ci_routes = $module_path."/Config/Routes.php";

        /* Angular Routes */
        $ar = file_get_contents($angular_routes);
        $ar = json_decode($ar, true);

        /* CI 4 Routes */
        $cr = $this->readPhpRoutes(file_get_contents($ci_routes));

        return [
            "angular" => $ar,
            "ci"      => $cr
        ];
    }
    
  function readPhpRoutes($string) {
    $routes = [];
    $pattern = '/(\$routes->(.*)\((.*)\,(.*)\))\;/';
    preg_match_all($pattern, $string, $matches);
    
    foreach($matches[0] as $index => $m){
    	$routes[] = [
        	"method" => $matches[2][$index],
            "route" => str_replace('"', '', str_replace("'","", $matches[3][$index])),
            "class" => str_replace('"', '', str_replace("'","", $matches[4][$index]))
    	];
    }
    
    return $routes;
}

   
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function sanitizeTitle($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);


        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        $words = explode("-", $text);

        foreach ($words as $key => $word) :
            $words[$key] = ucfirst($word);
        endforeach;

        if (empty($text)) {
            return 'n-a';
        }

        return implode("", $words);
    }


    public function run(array $params)
    {
        $config = [
            "module-slug" => null,
            "component-slug" => null,
            "component-title" => null
        ];

        if (isset($params[0])) /* Module Slug */
            $config["module-slug"]  = $params[0];

        if (isset($params[1])) /* Component Slug */
            $config["component-slug"] = $params[1];
            
        if (isset($params[2])) /* Component Slug */
            $config["component-title"] = $params[2];

        $this->slug = $this->slugify($config['module-slug']);
        $this->component_slug = $this->slugify($config['component-slug']);
        $this->title = $this->sanitizeTitle($config['component-title']);
        $existed_data = $this->getModules();

        if (in_array($this->component_slug, $existed_data["components"])) {
            CLI::write(CLI::color("Component `{$this->component_slug}` already exists.", 'red'));
            die;
        }

        if (file_exists(ROOTPATH . "stigniter/modules/{$this->slug}") || file_exists(ROOTPATH . "stigniter/system/system-modules/{$this->slug}")) {

            if ($this->createComponent($config)) {
                CLI::write('Component Created');
                CLI::write('View: ' . CLI::color("http://localhost:8080/{$this->slug}/{$this->component_slug}", 'green'));
            }

        }else{
            CLI::write('Error Occured: ' . CLI::color("There is no module by `{$this->slug}` ", 'red'));
        }
    }
}
