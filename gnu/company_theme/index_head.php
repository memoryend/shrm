<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet("<link rel=\"stylesheet\" href=\"".G5_THEME_URL."/plugin/jquery.bxslider/jquery.bxslider.css\">", 0);
add_javascript("<script src=\"".G5_THEME_URL."/plugin/jquery.bxslider/jquery.bxslider.js\"></script>",0);
add_javascript("<script src=\"".G5_THEME_URL."/js/main_bxslider.js\"></script>",0);

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
					<a href="<?php echo $row['me_link']; ?>" class="gnb_1da c_pointer"><?php echo $row['me_name'] ?></a>
					<?php
					for ($k=0; $row2=sql_fetch_array($result2); $k++) {
						if($k == 0)
							echo '<ul class="gnb_2dul">'.PHP_EOL;
					?>
						<li class="gnb_2dli"><a href="<?php echo $row2['me_link'];?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
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
<div id="index_wrapper">
	<div id="visual">
		<ul id="main_slider">
			<li><img src="<?php echo G5_THEME_URL?>/img/slide_tmp.jpg" alt="Slide tmp Image" /></li>
			<li><img src="<?php echo G5_THEME_URL?>/img/slide_tmp.jpg" alt="Slide tmp Image" /></li>
			<li><img src="<?php echo G5_THEME_URL?>/img/slide_tmp.jpg" alt="Slide tmp Image" /></li>
		</ul>
	</div>
    <div id="index_container">