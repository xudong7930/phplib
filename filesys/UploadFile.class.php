<?php 
/**
 * UploadFile.class.php surport multifile upload
 * example:
 * $up = new UploadFile($_FILES['files'], './tmp',"1");
 * $num = $up->upload();
 * if ($num != 0) {
 * 	  echo "upload sucess";
 * }
 * @lastmadify 2014年3月30日
 * @version 1.0
 * @author xudong <xudong7930@gmail.com>
 */
class UploadFile {
	protected $user_post_file = array(); //用户上传的文件
	protected $save_file_path = "./upload"; //存放用户上传文件的路径
	protected $max_file_size = 1048576000;  //文件最大尺寸 默认:1000M
	protected $last_error;	//记录文件最好一次出错信息
	protected $allow_type = array("gif","jpg","jpeg","png","rar","zip","txt","doc","pdf","docx","exe","deb","rpm","cvs","mp4","mp3","rmvb","avi"); //默认允许用户上传的文件类型
	protected $final_file_path; //最终保存的文件名
	protected $save_info = array(); //返回一组有用信息
	protected $is_rename = 1; //是否重命名上传文件


	/**
	 * __construct method
	 * @param [type]  $file [description]
	 * @param [type]  $path [description]
	 * @param integer $size [description]
	 * @param string  $type [description]
	 */
	function __construct($file,$savePath,$is_rename,$size=1048576000,$type='') {
		$this->user_post_file = $file; //$_FILES['upload'];
		$this->is_rename = $is_rename; //是否重命名文件
		if (!is_dir($savePath)) {  $this->createDir($savePath); }//create savepath directory
		if ($size) {$this->max_file_size = $size; } //allow max upload filesize
		if ($savePath) {$this->save_file_path = $savePath;} //save upload file path
		if ($type) { $this->allow_type = $type; } //allow upload file type

	}


	/**
	 * execute upload action
	 * @return int [upload success file numbers]
	 */
	public function upload() {

		$total = count($this->user_post_file['name']);

		for ($i=0; $i <$total; $i++) { 

			if ($this->user_post_file['error'][$i] ==0) {
				$name = $this->user_post_file['name'][$i]; //get file name
				$tmpname = $this->user_post_file['tmp_name'][$i];
				$size = $this->user_post_file['size'][$i];
				$mime_type = $this->user_post_file['type'][$i];
				$type = $this->getFileExt($this->user_post_file['name'][$i]);

				if (!$this->checkSize($size)) {
					$this->last_error = "the file size is too large. filename is:{$name}";
					$this->halt($this->last_error);
					continue;
				}

				if (!$this->checkType($type)) {
					$this->last_error = "unallowadble file type:{$type},filename is: {$name}";
					$this->halt($this->last_error);
					continue;
				}

				if (!is_uploaded_file($tmpname)) {
					$this->last_error = "invalid post file method. filename is:{$name}";
					$this->halt($this->last_error);
					continue;
				}

				$basename = $this->getBaseName($name,".".$type);

				$basename = iconv("UTF-8","gb2312",$basename);

				if ($this->is_rename == 1){
					$saveas = $basename.time().".".$type;
				}
				else {
					$saveas = $basename.".".$type;
				}
				

				$this->final_file_path = $this->save_file_path."/".$saveas;
				if (!move_uploaded_file($tmpname, $this->final_file_path)) {
					$this->last_error = $this->user_post_file['error'][$i];
					$this->halt($this->last_error);
					continue;
				}

				$this->save_info[] = array(
					"name"=>$name,
					"type"=>$type,
					"mime_type"=>$mime_type,
					"size"=>$size,
					"saveas"=>$saveas,
					"path"=>$this->final_file_path
				);
			}

		}

		return count($this->save_info);
	}


	/**
     * create directory
     * @param  string  $aimUrl 
     * @param  integer $mode 
     * @return none          
     */
    public function createDir($aimUrl, $mode = 0777) {
        $aimUrl = str_replace('', '/', $aimUrl);
        $aimDir = '';
        $arr = explode('/', $aimUrl);
        foreach ($arr as $str) {
            $aimDir .= $str . '/';
            if (!file_exists($aimDir)) {
                mkdir($aimDir, $mode);
            }
        }
    }


	public function getSaveInfo() {
		return $this->save_info;
	}


	protected function checkSize($size) {
		$flag = ($size > $this->max_file_size)?false:true;
		return $flag;
	}


	/**
	 * 检查文件类型
	 * @param  [type] $extension [description]
	 * @return boolean
	 */
	protected function checkType($extension) {
		$ext = strtolower($extension);
		return in_array($ext, $this->allow_type);
	}


	protected function halt($msg) {
		echo "<b>UploadFile ERROR:</b> {$msg} <br>"; 
	}


	protected function getFileExt($filename) {
		$stuff = pathinfo($filename);
		return $stuff['extension'];
	}


	protected function getBaseName($filename,$type) {
		$basename = basename($filename,$type);
		return $basename;
	}

}