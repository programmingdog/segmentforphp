<?php
	/**
	* 正向最大匹配分词类
	* code by 小志
	*/
	class Segment
	{
		
		const SEPERATE = "/"; //定义分隔符常量
		function __construct()
		{
			# code...
		}
		
		
		/*
		 * 截取中文字符串函数
		* @param string $str 字符串
		* @parma integer @mylen 长度
		* return string 字符串
		*/
		static function substr_CN($str,$mylen){
			$len=strlen($str);
			$content='';
			$count=0;
			for($i=0;$i<$len;$i++){
				if(ord(substr($str,$i,1))>127){
					$content.=substr($str,$i,2);
					$i++;
				}else{
					$content.=substr($str,$i,1);
				}
				if(++$count==$mylen){
					break;
				}
			}
			return $content;
		}
		
		/*
		 * 初始化分词词典函数
		 * @param string $dictPath 词典文件路径
		 * return array() 返回词典数组（每个数组元素为一个词）
		 */
		static function dictinit($dictPath){

			if ($dictPath!="") {
				
				$result = preg_replace('/\r|\n/', '', file($dictPath));
				return $result;
			}else
			{
				return "Read dict failed";
			}
		}
		
		/*分词主函数
		 * @param string $s1 待分词文档字符串
		 * @param string $s2 分词结果字符串
		 * @param string $w 正向最大匹配候选字符串，用该字符串不断去跟词典比对
		 * @param array() $dict 词典数组
		 * @param integer $maxLength 最大词长
		 * return string $s2 切分结果返回
		 */
		static function seg($s1,$s2,$w,$dict,$maxLength){
			
			$len = strlen($s1);
			if ($maxLength<$len)
			{
				$len = $maxLength;
			}
			echo "最大词长len:".$len."<br><br>";
			echo "分词过程：<br><br>";
			while ($s1!="")
			{
				echo "s1:".$s1."<br>";
				$w = self::substr_CN($s1, $len);
				while (!in_array($w, $dict))
				{
					$len -= 1;
					$w = self::substr_CN($s1, $len);
					if (strlen($w)==2)
					{
						break;
					}
				}
				echo "w:".$w."<br>";
				$s1 = str_replace($w, "", $s1);
				$s2 .= $w.self::SEPERATE;
				$len = $maxLength;
				
			}
			echo "<br>最终分词结果:".$s2."<br>";
			return $s2;
			
		}
	}
?>