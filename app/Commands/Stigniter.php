<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Stigniter extends BaseCommand
{

    protected $group       = 'Steigenberg';
    protected $name        = 'create-module';
    protected $description = 'Creates module boilerplate.';

    protected $folders = [
        "Components",
        "Config",
        "Controllers",
        "Css",
        "Languages",
        "Views"
    ];

    protected $files = [
        "Config/db.json",
        "Config/routes.json",
        "Config/Routes.php",
        "Controllers/{sanitized_title}.php", /* Controller File*/
        "Css/{sanitized_title}.css",
        "Languages/en.json",
        "Views/view_{sanitized_title}.php",
        "Components/{slug}.js"
    ];

    protected $onCreate = [
        "Config/db.json" => "db.json",
        "Config/routes.json" => "routes.json",
        "Config/Routes.php" => "Routes.php",
        "Controllers/{sanitized_title}.php" => "Controllers.php",
        "Views/view_{sanitized_title}.php" => "view.php",
        "Components/{slug}.js"  => "Component.js"
    ];

    private function getModules(){
        $system_modules = ROOTPATH."stigniter/system/system-modules/";
        $public_modules = ROOTPATH."stigniter/modules/";

        $modules = [];
        $components = [];

        foreach(scandir($system_modules) as $index => $m){
            if($index > 1){
                $modules[] = $m;
                /* Components */
                $components_path = $system_modules.$m."/Components/";
                
                foreach(scandir($components_path) as $ind => $c){
                    if($ind > 1){
                        $c = str_replace(".js", "", $c);
                        $components[] = $c;
                    }
                }
            }
        }

        foreach(scandir($public_modules) as $index => $m){
            if($index > 1){
                $modules[] = $m;
                  /* Components */
                  $components_path = $public_modules.$m."/Components/";
                
                  foreach(scandir($components_path) as $ind => $c){
                      if($ind > 1){
                          $c = str_replace(".js", "", $c);
                          $components[] = $c;
                      }
                  }
            }
        }

        

        return [
            "components" => $components,
            "modules"    => $modules
        ];
    }

    private function createModule($config = [])
    {
        if (empty($config)) return false;
        $type = $config['module-type'];
        $types = ["public", "system"];
        if (in_array($type, $types)) {
            /* Lets Make A Module */
            $system_path = ROOTPATH . "stigniter/system/system-modules/";
            $public_path = ROOTPATH . "stigniter/modules/";

            $path = ($type == "public") ? $public_path : $system_path;
           

            $full_path = $path . $this->slug;

            /* Create Module */
            mkdir($full_path);

            /* Sanitized Title */
            $this->title = $this->sanitizeTitle($config['module-title']);


            $this->template_variables = [
                "module-path" => $full_path,
                "module-type" => ($type == "public") ? "Modules" : "SystemModules",
                "slug"        => $config['module-slug'],
                "sanitized_title" => $this->title
            ];


            /* Create Folders */
            $are_folders_created = $this->createFolders($full_path);

            if ($are_folders_created)
                $this->createFiles($full_path);

            return true;
        }



        return false;
    }

    private function createFiles($module_dir = false)
    {
        if (!$module_dir) return false;
        $template_dir = __DIR__ . "/files-template/";

        foreach ($this->files as $file) :
            $template_content = (isset($this->onCreate[$file])) ? file_get_contents($template_dir . $this->onCreate[$file]) : "";


            $file = str_replace("{sanitized_title}", $this->title, $file);
            $file = str_replace("{slug}", $this->template_variables['slug'], $file);

            foreach($this->template_variables as $k => $t):
                $template_content = str_replace("{".$k."}", $t, $template_content);
            endforeach;


            file_put_contents($module_dir . "/" . $file, $template_content);
        endforeach;
    }

    private function createFolders($module_dir = false)
    {
        if (!$module_dir) return false;
        foreach ($this->folders as $f) :
            $f = str_replace("{sanitized_title}", $this->title, $f);
            $f = str_replace("{slug}", $this->template_variables['slug'], $f);

            mkdir($module_dir . "/" . $f);
        endforeach;

        return true;
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
            "module-type" => "public"
        ];

        if (isset($params[0])) /* Module Slug */
            $config["module-slug"]  = $params[0];

        if (isset($params[1])) /* Module Title */
            $config["module-title"] = $params[1];

        if (isset($params[2])) /* Module Type */
            $config["module-type"]  =  $params[2];

        $this->slug = $this->slugify($config['module-slug']);

        $existed_data = $this->getModules();

       
        if(in_array($this->slug, $existed_data["modules"])){
            CLI::write(CLI::color("Module `{$this->slug}` already exist.", 'red'));
            die;
        }

        if(in_array($this->slug, $existed_data["components"])){
            CLI::write(CLI::color("Component `{$this->slug}` already exist.", 'red'));
            die;
        }

        if ($this->createModule($config)) {
            CLI::write('Module Created');
            CLI::write('Module View: ' . CLI::color("http://localhost:8080/{$config['module-slug']}", 'green'));
        }

    }
}
