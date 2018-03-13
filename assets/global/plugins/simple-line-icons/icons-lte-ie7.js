/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="fonts-family: \'Simple-Line-Icons\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-user-unfollow' : '&#xe000;',
			'icon-user-friends' : '&#xe001;',
			'icon-user-following' : '&#xe002;',
			'icon-user-follow' : '&#xe003;',
			'icon-trophy' : '&#xe004;',
			'icon-speedometer' : '&#xe005;',
			'icon-social-youtube' : '&#xe006;',
			'icon-social-twitter' : '&#xe007;',
			'icon-social-tumblr' : '&#xe008;',
			'icon-social-facebook' : '&#xe009;',
			'icon-social-dropbox' : '&#xe00a;',
			'icon-social-dribbble' : '&#xe00b;',
			'icon-shield' : '&#xe00c;',
			'icon-screen-tablet' : '&#xe00d;',
			'icon-screen-smartphone' : '&#xe00e;',
			'icon-screen-desktop' : '&#xe00f;',
			'icon-plane' : '&#xe010;',
			'icon-notebook' : '&#xe011;',
			'icon-moustache' : '&#xe012;',
			'icon-mouse' : '&#xe013;',
			'icon-magnet' : '&#xe014;',
			'icon-magic-wand' : '&#xe015;',
			'icon-hourglass' : '&#xe016;',
			'icon-graduation' : '&#xe017;',
			'icon-ghost' : '&#xe018;',
			'icon-game-controller' : '&#xe019;',
			'icon-fire' : '&#xe01a;',
			'icon-eyeglasses' : '&#xe01b;',
			'icon-envelope-open' : '&#xe01c;',
			'icon-envelope-letter' : '&#xe01d;',
			'icon-energy' : '&#xe01e;',
			'icon-emoticon-smile' : '&#xe01f;',
			'icon-disc' : '&#xe020;',
			'icon-cursor-move' : '&#xe021;',
			'icon-crop' : '&#xe022;',
			'icon-credit-card' : '&#xe023;',
			'icon-chemistry' : '&#xe024;',
			'icon-bell' : '&#xe025;',
			'icon-badge' : '&#xe026;',
			'icon-anchor' : '&#xe027;',
			'icon-action-redo' : '&#xe028;',
			'icon-action-undo' : '&#xe029;',
			'icon-bag' : '&#xe02a;',
			'icon-basket' : '&#xe02b;',
			'icon-basket-loaded' : '&#xe02c;',
			'icon-book-open' : '&#xe02d;',
			'icon-briefcase' : '&#xe02e;',
			'icon-bubbles' : '&#xe02f;',
			'icon-calculator' : '&#xe030;',
			'icon-call-end' : '&#xe031;',
			'icon-call-in' : '&#xe032;',
			'icon-call-out' : '&#xe033;',
			'icon-compass' : '&#xe034;',
			'icon-cup' : '&#xe035;',
			'icon-diamond' : '&#xe036;',
			'icon-direction' : '&#xe037;',
			'icon-directions' : '&#xe038;',
			'icon-docs' : '&#xe039;',
			'icon-drawer' : '&#xe03a;',
			'icon-drop' : '&#xe03b;',
			'icon-earphones' : '&#xe03c;',
			'icon-earphones-alt' : '&#xe03d;',
			'icon-feed' : '&#xe03e;',
			'icon-film' : '&#xe03f;',
			'icon-folder-alt' : '&#xe040;',
			'icon-frame' : '&#xe041;',
			'icon-globe' : '&#xe042;',
			'icon-globe-alt' : '&#xe043;',
			'icon-handbag' : '&#xe044;',
			'icon-layers' : '&#xe045;',
			'icon-map' : '&#xe046;',
			'icon-picture' : '&#xe047;',
			'icon-pin' : '&#xe048;',
			'icon-playlist' : '&#xe049;',
			'icon-present' : '&#xe04a;',
			'icon-printer' : '&#xe04b;',
			'icon-puzzle' : '&#xe04c;',
			'icon-speech' : '&#xe04d;',
			'icon-vector' : '&#xe04e;',
			'icon-wallet' : '&#xe04f;',
			'icon-arrow-down' : '&#xe050;',
			'icon-arrow-left' : '&#xe051;',
			'icon-arrow-right' : '&#xe052;',
			'icon-arrow-up' : '&#xe053;',
			'icon-bar-chart' : '&#xe054;',
			'icon-bulb' : '&#xe055;',
			'icon-calendar' : '&#xe056;',
			'icon-control-end' : '&#xe057;',
			'icon-control-forward' : '&#xe058;',
			'icon-control-pause' : '&#xe059;',
			'icon-control-play' : '&#xe05a;',
			'icon-control-rewind' : '&#xe05b;',
			'icon-control-start' : '&#xe05c;',
			'icon-cursor' : '&#xe05d;',
			'icon-dislike' : '&#xe05e;',
			'icon-equalizer' : '&#xe05f;',
			'icon-graph' : '&#xe060;',
			'icon-grid' : '&#xe061;',
			'icon-home' : '&#xe062;',
			'icon-like' : '&#xe063;',
			'icon-list' : '&#xe064;',
			'icon-login' : '&#xe065;',
			'icon-logout' : '&#xe066;',
			'icon-loop' : '&#xe067;',
			'icon-microphone' : '&#xe068;',
			'icon-music-tone' : '&#xe069;',
			'icon-music-tone-alt' : '&#xe06a;',
			'icon-note' : '&#xe06b;',
			'icon-pencil' : '&#xe06c;',
			'icon-pie-chart' : '&#xe06d;',
			'icon-question' : '&#xe06e;',
			'icon-rocket' : '&#xe06f;',
			'icon-share' : '&#xe070;',
			'icon-share-alt' : '&#xe071;',
			'icon-shuffle' : '&#xe072;',
			'icon-size-actual' : '&#xe073;',
			'icon-size-fullscreen' : '&#xe074;',
			'icon-support' : '&#xe075;',
			'icon-tag' : '&#xe076;',
			'icon-trash' : '&#xe077;',
			'icon-umbrella' : '&#xe078;',
			'icon-wrench' : '&#xe079;',
			'icon-ban' : '&#xe07a;',
			'icon-bubble' : '&#xe07b;',
			'icon-camcorder' : '&#xe07c;',
			'icon-camera' : '&#xe07d;',
			'icon-check' : '&#xe07e;',
			'icon-clock' : '&#xe07f;',
			'icon-close' : '&#xe080;',
			'icon-cloud-download' : '&#xe081;',
			'icon-cloud-upload' : '&#xe082;',
			'icon-doc' : '&#xe083;',
			'icon-envelope' : '&#xe084;',
			'icon-eye' : '&#xe085;',
			'icon-flag' : '&#xe086;',
			'icon-folder' : '&#xe087;',
			'icon-heart' : '&#xe088;',
			'icon-info' : '&#xe089;',
			'icon-key' : '&#xe08a;',
			'icon-link' : '&#xe08b;',
			'icon-lock' : '&#xe08c;',
			'icon-lock-open' : '&#xe08d;',
			'icon-magnifier' : '&#xe08e;',
			'icon-magnifier-add' : '&#xe08f;',
			'icon-magnifier-remove' : '&#xe090;',
			'icon-paper-clip' : '&#xe091;',
			'icon-paper-plane' : '&#xe092;',
			'icon-plus' : '&#xe093;',
			'icon-pointer' : '&#xe094;',
			'icon-power' : '&#xe095;',
			'icon-refresh' : '&#xe096;',
			'icon-reload' : '&#xe097;',
			'icon-settings' : '&#xe098;',
			'icon-star' : '&#xe099;',
			'icon-symbol-female' : '&#xe09a;',
			'icon-symbol-male' : '&#xe09b;',
			'icon-target' : '&#xe09c;',
			'icon-user-female' : '&#xe09d;',
			'icon-user-male' : '&#xe09e;',
			'icon-volume-1' : '&#xe09f;',
			'icon-volume-2' : '&#xe0a0;',
			'icon-volume-off' : '&#xe0a1;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};