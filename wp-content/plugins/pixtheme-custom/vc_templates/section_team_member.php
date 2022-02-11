<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $image
 * @var $name
 * @var $position
 * @var $skill
 * @var $scn1
 * @var $scn_icon1
 * @var $scn2
 * @var $scn_icon2
 * @var $scn3
 * @var $scn_icon3
 * @var $scn4
 * @var $scn_icon4
 * @var $scn5
 * @var $scn_icon5
 * @var $scn6
 * @var $scn_icon6
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Team_Member
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$img_id = preg_replace( '/[^\d]/', '', $image );
$img_link = wp_get_attachment_image_src( $img_id, 'large' );
$img_link = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

$final_scn1 = ($scn1 == '') ? '': '<li><a class="icon fa '.esc_attr($scn_icon1).'" href="'.esc_url($scn1).'"></a></li>';
$final_scn2 = ($scn2 == '') ? '': '<li><a class="icon fa '.esc_attr($scn_icon2).'" href="'.esc_url($scn2).'"></a></li>';
$final_scn3 = ($scn3 == '') ? '': '<li><a class="icon fa '.esc_attr($scn_icon3).'" href="'.esc_url($scn3).'"></a></li>';
$final_scn4 = ($scn4 == '') ? '': '<li><a class="icon fa '.esc_attr($scn_icon4).'" href="'.esc_url($scn4).'"></a></li>';
//$final_scn5 = ($scn5 == '') ? '': '<li><a href="'.esc_url($scn5).'"><span class="ef '.esc_attr($scn_icon5).'"></span></a></li>';
//$final_scn6 = ($scn6 == '') ? '': '<li><a href="'.esc_url($scn6).'"><span class="ef '.esc_attr($scn_icon6).'"></span></a></li>';


if (!$skill) { $skill_class = 'staff-no-skill';
}else{$skill_class = '';}

			
$out = '
		<li class="list-staff__item clearfix '.esc_attr($skill_class).'">
			<div class="list-staff__media">
				<img class="img-responsive" src="'.esc_url($img_link).'" height="280" width="280" alt="'.esc_attr($image_alt).'">';
				if($scn1 || $scn2 || $scn3 || $scn4 ){
					$out .= '
					<ul class="list-staff__social list-inline">
						'.$final_scn1.$final_scn2.$final_scn3.$final_scn4.'
					</ul>';
				}
				$out .= '
			</div>
			<!-- end list-staff__media -->

			<div class="list-staff__inner">
				<div class="list-staff__info">
					<div class="list-staff__wrap_name">
						<div class="list-staff__name">'.wp_kses_post($name).'</div>
						<div class="list-staff__categories">'.wp_kses_post($position).'</div>
					</div>
					<div class="decor-1"></div>
					<div class="list-staff__description">
						'.do_shortcode($content).'
					</div>
				</div>
				<div class="staff-progress">
					<div class="staff-progress__title"><i class="decor-3 fa fa-caret-right"></i>'.esc_html__( 'SKILL LEVEL', 'autozone' ).'</div>
					<div class="progress progress-striped active">
						<div class="progress-bar" role="progressbar" aria-valuenow="'.esc_attr($skill).'" aria-valuemin="0" aria-valuemax="100" style="width: '.esc_attr($skill).'%"> </div>
					</div>
				</div>
			</div>
			<!-- end list-staff__inner -->
		</li>
		
	';

echo $out;