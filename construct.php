<?php 

$function = $argv[1];

$views_path = '/backsys/views/';
$controllers_path = '/backsys/controllers/';

switch ($argv[1]) {
    case 'create':
		if (!empty($argv[2])) {
			$filename = $argv[2];
			$controller_name = 'c_'.$filename;
			$view_name = 'v_'.$filename;

			if ( (!is_dir(__DIR__.$views_path.$controller_name)) && (!file_exists(__DIR__.$controllers_path.$controller_name.'.php')) ) {
				mkdir(__DIR__.$views_path.$controller_name);

				$views_folder = __DIR__.$views_path.$controller_name.'/';
				$controllers_folder = __DIR__.$controllers_path.'/';

				mkdir($views_folder.'assets');

				// DOSSIER ET FICHIER JS PROPRE A LA VUE
				mkdir($views_folder.'assets/js');
				$js = fopen($views_folder.'assets/js/'.$filename.'.js', "x+");

				// DOSSIER ET FICHIER CSS PROPRE A LA VUE
				mkdir($views_folder.'assets/css');
				$css = fopen($views_folder.'assets/css/'.$filename.'.css', "x+");

				// VUE.PHP
				mkdir($views_folder.'subviews');
				$vue = fopen($views_folder.$view_name.'.php', "x+");

				// CONTROLLER.PHP
				$controller = fopen($controllers_folder.$controller_name.'.php', "x+");
				$controller_content = "<?php";
				$controller_content .= "\n\t".'use \core\controller;';
				$controller_content .= "\n\t".'use \core\model;';
				$controller_content .= "\n\t".'use \core\database;';
				$controller_content .= "\n\t".'use \entities\validate;';
				$controller_content .= "\n\n";
				$controller_content .= "\t".'class '.$controller_name.' extends controller{';
				$controller_content .= "\n\t\t".'private $user = null;'."\n\t\t".'private $bdd = null;'."\n\t\t".'private $db = null;'."\n\n\t\t";
				$controller_content .= 'public function __construct(){';
				$controller_content .= "\n\t\t\t".'$this->user = null;';
				$controller_content .= "\n\t\t\t".'$this->bdd = new database();';
				$controller_content .= "\n\t\t\t".'$this->db = $this->bdd->connect(DB_HOST, DB_NAME, DB_USER, DB_PASS, PORT);';

				$controller_content .= "\n\n\t\t\t".'$this->use = model::loadTable("user");';
				$controller_content .= "\n\t\t\t".'$this->use->set($this->db);'."\n";

				$controller_content .= "\n\t\t\t".'require_once ENTITIES."crypto.php";';
				$controller_content .= "\n\t\t\t".'require_once ENTITIES."emailer.php";';
				$controller_content .= "\n\t\t\t".'require_once ENTITIES."validate.php";';

				$controller_content .= "\n\t\t".'}'."\n\n";

				$controller_content .= "\t\t".'public function '.$view_name.'(){'."\n";
				$controller_content .= "\t\t\t".'$_SESSION["page"] = "'.$view_name.'";'."\n\n";
				$controller_content .= "\t\t\t".'$data["params"] = ['."\n";
				$controller_content .= "\t\t\t\t".'"title" => "",'."\n";
				$controller_content .= "\t\t\t\t".'"description" => ""'."\n";
				$controller_content .= "\t\t\t".'];'."\n\n";
				$controller_content .= "\t\t\t".'$this->set_params($data);'."\n";
				$controller_content .= "\t\t\t".'$this->render("'.$view_name.'");'."\n";
				$controller_content .= "\t\t".'}'."\n";
				$controller_content .= "\t".'}'."\n";
				$controller_content .= '?>'."\n";
				fputs($controller,utf8_encode($controller_content));
				fclose($controller);
			}
			else{
				echo "\n".'///////////////////////////////////////////////////////////';
				echo "\n\n".'La vue/controller que vous essayer de creer existe déja'."\n\n";
				echo '///////////////////////////////////////////////////////////'."\n";

			}
		}else{
			echo "\n".'///////////////////////////////////////////////////////////';
			echo "\n\n"."Il est necessaire de saisir un nom de vue/controller"."\n";
			echo "\n"."Exemple : construct.php create [nom]"."\n\n";
			echo '///////////////////////////////////////////////////////////'."\n";
		}
		break;
	case 'delete':
		echo "Supprimer Une vue/controller";
		break;
	default:
       	echo "\n".'///////////////////////////////////////////////////////////';
		echo "\n\n"."Aucune fonction n'a été reconnue. Commande : construct.php [fonction] [arg1] [arg2] "."\n\n";
		echo '///////////////////////////////////////////////////////////'."\n";
}

?>