<?php
	
	class Page{
		public static function show($basename,$counts,$page = 1){
			//计算出总页数
			$pagesize = 16;
			$pageCounts = ceil($counts / $pagesize);

			//判断，如果没有数据的话，直接返回一个空字符串
			if($pageCounts == 0) return '';

			//计算上一页和下一页
			$prev = ($page == 1) ? $page : ($page - 1);
			$next = ($page == $pageCounts) ? $page : ($page + 1);
			
			//使用定界符来平凑字符串
			$str = <<<ENDF
			<span>
			总共有{$counts}条记录，每页显示{$pagesize}条,当前是第{$page}页&nbsp;&nbsp;
			<a href="{$basename}&page=1">首页</a>
			<a href="{$basename}&page={$prev}">上一页</a>
			<a href="{$basename}&page={$next}">下一页</a>
			<a href="{$basename}&page={$pageCounts}">末页</a>&nbsp;&nbsp;</span>
ENDF;
		return $str;
		}
}