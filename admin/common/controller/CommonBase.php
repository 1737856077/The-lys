<?php /* 
-- enphp : https://git.oschina.net/mz/mzphp2
 */
 namespace app\common\controller;error_reporting(E_ALL^E_NOTICE);define('�', '��');�⤋��܍��ы��;$_SERVER[�] = explode('|||', gzinflate(substr('�      uS�n�0�#Q/�J4٭���m%(+�u+8 d�:��+ǎ��n��q��W���+G��NW��/���6�@9d���͛�1��%Sq:{pv��~�����V��V�f%n�P�S!���X��ƫ>U8P=*tZ�;}2Z�F8	�|�
��zڜ=G���y�m�c�Y*�����K�Y�O�&�A.�;����q�=��)c`����������W��W�=\'�B%e5��\'R��q��}۸��Ecc����L( ���Č��0M����"e�r#J�$������a�\\ڙ
��i�KT��.�y�a���J+�;^-CjUa%�BX[����Պ��uʧ@+M�FE9��
�hX�&Ö�߮w��w������~=���}�p-��-�\'����i��-�D��ia�z8�9���u�W��wuQA�-@=��Ph�.�@�=�ͽU�n:Z�wG�;>��	�Q��-�ȭ7.�����|]{�^h5�/��I_٫��G���#*7��V�����\'6C���mjA��2��TH	ɣ�-s]�@b$����c{����Z���&VZJx���Q�6֦����F��z  ',0x0a, -8)));��ʗ�����Ɓ��б��������������������ʚ��������Ɏ��睠���Գ��������б����ƹ����܇�����������跏�έ�������;use think\Controller;use think\Db;use think\db\Query;use think\Request;use think\Image;use think\Session;class CommonBase extends Controller{public $listCommSalesmanBusines=array();public $CommBusinesIDs=array();public function __construct(Request$�И��){parent::$_SERVER{�}[0]($�И��);����ւ���ݞ��Ӕ����ٸ�γ��Ũ��������������ȴ���ƪ��;}public function _initialize(){$�����=&$_SERVER{�};$�����{0x001}($�����[0x0002]);�������;$��=\think\Request::$�����{0x00003}();$҇=$��->$�����[0x000004]();$���=$��->$�����{0x05}();$�⾄�=$��->$�����[0x006]();$�����=$�����{0x0007}("$҇/$���/$�⾄�");$�=$this->$�����[0x00008]();$�ߎ�=array($�����{0x000009},$�����[0x0a],$�����{0x00b},$�����[0x000c]);���섽���黛������ç�;if(!$�����{0x0000d}($�,$�ߎ�)){echo $�����[0x00000e];exit;}include_once $�����{0x0f};$��=Request::$�����{0x00003}();���ȇ���������;$�=$�����[0x0010]($�����{0x00011});if(!Session::$�����[0x000012]($�����{0x0000013})){echo $�����[0x014];exit;}$�=Session::$�����{0x0015}($�����[0x00016]);$�=(Array)$�����{0x000017}($�);�����⯗��߭�¢�➩������ԁ���밿݀����橴�����������媢������͹;$����=\think\Config::$�����{0x0015}($�����[0x0000018]);�����;$�=$�����{0x019}($�,$����);���˃���������׎���ץ�����������������۔̾�����Ӹ�������������;if(Session::$�����{0x0015}($�����{0x0000013})!=$�����[0x001a]){if(!$�����{0x0000d}($�����,$�)){echo $�����;echo $�����{0x0001b};exit;}}if(Session::$�����{0x0015}($�����[0x00001c])==$�����{0x000001d}){$this->listCommSalesmanBusines=Db::$�����[0x01e]($�����[0x001a])->$�����{0x001f}($�����[0x00020].Session::$�����{0x0015}($�����{0x000021}).$�����[0x0000022])->$�����{0x023}();foreach($this->listCommSalesmanBusines  as $���=>$�){$this->CommBusinesIDs[]=$�[$�����[0x0024]];}$this->$�����{0x00025}($�����[0x000026],$this->listCommSalesmanBusines);$this->$�����{0x00025}($�����{0x0000027},$this->CommBusinesIDs);if(!$�����[0x028]($this->listCommSalesmanBusines)){echo $�����{0x0029};exit;}}if(Session::$�����{0x0015}($�����[0x00001c])==$�����[0x0002a]){$ݍ��=Db::$�����[0x01e]($�����[0x001a])->$�����{0x001f}($�����{0x00002b}.$�����[0x000002c](Session::$�����{0x0015}($�����{0x000021})))->$�����{0x02d}();if($ݍ��[$�����[0x002e]]==0x0002){$this->listCommSalesmanBusiness=Db::$�����[0x01e]($�����{0x0002f})->$�����{0x001f}($�����[0x000030].$�����[0x000002c](Session::$�����{0x0015}($�����{0x000021})))->$�����{0x023}();foreach($this->listCommSalesmanVillage  as $���=>$�){$this->CommBusinesIDs[]=$�[$�����{0x0000031}];}$this->$�����{0x00025}($�����[0x032],$this->listCommSalesmanBusiness);$this->$�����{0x00025}($�����{0x0000027},$this->CommBusinesIDs);}}}public function GetServerHostUrl(){$�=&$_SERVER{�};if($_SERVER[$�{0x0033}]!=$�[0x00034]){$���=$�{0x000035}.$_SERVER[$�[0x0000036]].$�{0x037}.$_SERVER[$�{0x0033}];}else{$���=$�{0x000035}.$_SERVER[$�[0x0000036]];}return $���;}public function GetServerHost(){return $_SERVER[$_SERVER{�}[0x0000036]];�������Ɍ�˅�Ǎ�����;}public function PostSend($�,$��,$�="POST"){$��=&$_SERVER{�};$��ȕ=$��[0x0038]();�ꚫ�Ճ��;$��{0x00039}($��ȕ,CURLOPT_URL,$�);$��{0x00039}($��ȕ,CURLOPT_CUSTOMREQUEST,$�);$��{0x00039}($��ȕ,CURLOPT_SSL_VERIFYPEER,!1);$��{0x00039}($��ȕ,CURLOPT_SSL_VERIFYHOST,!1);$��{0x00039}($��ȕ,CURLOPT_USERAGENT,$��[0x00003a]);$��{0x00039}($��ȕ,CURLOPT_FOLLOWLOCATION,0x001);�����Ž��;$��{0x00039}($��ȕ,CURLOPT_AUTOREFERER,0x001);$��{0x00039}($��ȕ,CURLOPT_POSTFIELDS,$��);$��{0x00039}($��ȕ,CURLOPT_RETURNTRANSFER,!0);$��ɢ=$��{0x000003b}($��ȕ);if($��[0x03c]($��ȕ)){return $��{0x003d}($��ȕ);}$��[0x0003e]($��ȕ);return $��ɢ;}static function auth($���){$�=&$_SERVER{�};$���=Session::$�{0x0015}($�[0x00016]);$���=$�{0x000017}($���);������������������Í�������������;if(Session::$�{0x0015}($�{0x0000013})==$�[0x001a]){return !0;}else{if($�{0x0000d}($���,$���)){return !0;}}return !1;}}