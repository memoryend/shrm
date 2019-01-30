<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">

    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

	<div id="hd_topbar">
	
		<div id="hd_topbar_wrapper">
			<div class="topbar_box"></div>
			<div class="topbar_box">
				<ul id="tnb">
					<?php if ($is_member) {  ?>
					<?php if ($is_admin) {  ?>
					<li><a href="<?php echo G5_ADMIN_URL ?>">관리자</a></li>
					<?php }  ?>
					<li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
					<li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
					<?php } else {  ?>
					<li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a></li>
					<li><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
					<?php }  ?>
				</ul>
			</div>
		</div>

	</div>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>

    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>">logo</a>
        </div>

		<nav id="cb_gnb">
			<h2>메인메뉴</h2>
			<ul id="gnb_1dul">
				<?php
				$sql = " select *
							from {$g5['menu_table']}
							where me_use = '1'
							  and length(me_code) = '2'
							order by me_order, me_id ";
				$result = sql_query($sql, false);
				$gnb_zindex = 999; // gnb_1dli z-index 값 설정용

				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$sql2 = " select *
								from {$g5['menu_table']}
								where me_use = '1'
								  and length(me_code) = '4'
								  and substring(me_code, 1, 2) = '{$row['me_code']}'
								order by me_order, me_id ";
					$result2 = sql_query($sql2);
					$result2_cnt = sql_num_rows($result2);
				?>
				<li class="gnb_1dli" style="z-index:<?php echo $gnb_zindex--; ?>">
					<a href="<?php echo $row['me_link']; ?>" class="gnb_1da<?php  if($result2_cnt==0) echo " c_pointer";?>"><?php echo $row['me_name'] ?></a>
					<?php
					for ($k=0; $row2=sql_fetch_array($result2); $k++) {
						if($k == 0)
							echo '<ul class="gnb_2dul">'.PHP_EOL;
					?>
						<li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
					<?php
					}

					if($k > 0)
						echo '</ul>'.PHP_EOL;
					?>
				</li>
				<?php
				}

				if ($i == 0) {  ?>
					<li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
				<?php } ?>
			</ul>
		</nav>

    </div>

</div>
<!-- } 상단 끝 -->

<hr>

<!-- 콘텐츠 시작 { -->

<div style="height:200px;background:#cdcdcd;">
</div>

<div id="wrapper">

	<div id="aside">
		<?php
		if($g5['title'] || $board['bo_subject']){
		
			if($g5['title']) $sb_mn = $g5['title'];
			if($board['bo_subject']) $sb_mn = $board['bo_subject'];

			$sbc_sql = "select substring(me_code, 1, 2) as me_code from {$g5['menu_table']} where me_name='{$sb_mn}'";
			$sbc_result = sql_query($sbc_sql);
			
			$sb_code = sql_fetch_array($sbc_result);

			if($sb_code){
				$sb_sql = "select * from {$g5['menu_table']} where me_code like '{$sb_code['me_code']}%'";
				$sb_result = sql_query($sb_sql);
				
				echo '<ul class="am_ul">'.PHP_EOL;
				for($l=0; $sb_row=sql_fetch_array($sb_result); $l++){
					if($l == 0) {
		?>
						<li class="am_first">
							<?php 
								echo $sb_row['me_name'];
								echo "<div class=\"amf_cut_box amf_cut_1\"></div>";
								echo "<div class=\"amf_cut_box amf_cut_2\"></div>";
							?>
						</li>
		<?php
					}else{
						if($sb_mn==$sb_row['me_name']){$li_on = "on";}else{$li_on = "";}
		?>
						<li class="<?php echo $li_on?>">
							<a href="<?php echo $sb_row['me_link']; ?>" target="_<?php echo $sb_row['me_target']; ?>"><?php echo $sb_row['me_name'] ?></a>
						</li>
		<?php
					}
				}
				echo '</ul>'.PHP_EOL;
			}else{

				echo '<ul class="am_ul">'.PHP_EOL;
					echo '<li class="am_first">'.PHP_EOL;
						echo $g5['title'].PHP_EOL;
						echo '<div class="amf_cut_box amf_cut_1"></div>'.PHP_EOL;
						echo '<div class="amf_cut_box amf_cut_2"></div>'.PHP_EOL;
					echo '</li>'.PHP_EOL;
				echo '</ul>'.PHP_EOL;

			}
		}
		?>
	</div>
    <div id="container">