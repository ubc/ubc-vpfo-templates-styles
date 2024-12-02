<?php
$display_survey = get_post_meta( get_the_ID(), '_vpfo_display_survey', true ) ?? '0';

$survey_heading = get_option( 'vpfo_survey_heading', null );
if ( ! $survey_heading ) {
	$survey_heading = __( 'Did you find what you were looking for?', 'ubc-vpfo-templates-styles' );
}

$survey_intro = get_option( 'vpfo_survey_intro', null );
if ( ! $survey_intro ) {
	$survey_intro = __( 'Your response will redirect you to our feedback survey.', 'ubc-vpfo-templates-styles' );
}

$survey_yes = get_option( 'vpfo_survey_yes', null );
if ( ! $survey_yes ) {
	// translators: %s is the survey link
	$survey_yes = sprintf( '<p>' . __( 'Thanks for your repsonse! If you\'d like to share further feedback, please <a href="%s" target="_blank">take our survey</a>.', 'ubc-vpfo-templates-styles' ) . '</p>', 'https://ubc.ca1.qualtrics.com/jfe/form/SV_9nPuRCzXI8gVtxI' );
}

$survey_no = get_option( 'vpfo_survey_no', null );
if ( ! $survey_no ) {
	// translators: %s is the survey link
	$survey_no = sprintf( '<p>' . __( 'Thanks for your repsonse! If you\'d like to share further feedback, please <a href="%s" target="_blank">take our survey</a>.', 'ubc-vpfo-templates-styles' ) . '</p>', 'https://ubc.ca1.qualtrics.com/jfe/form/SV_9nPuRCzXI8gVtxI' );
}

if ( '1' === $display_survey ) {
	?>
	<section class="survey-feedback mt-9 py-9 px-5">
		<div class="survey-wrapper d-flex flex-column flex-md-row align-items-center justify-content-center">
			<div class="survey-intro-wrapper text-center text-md-start">
				<h3 class="h4 survey-heading m-0"><?php echo esc_html( $survey_heading ); ?></h3>
				<p class="survey-intro mt-3"><?php echo esc_html( $survey_intro ); ?></p>
			</div>
			<div class="survey-buttons d-flex align-items-center">
				<button class="btn btn-secondary" id="survey-yes"><?php esc_html_e( 'Yes', 'ubc-vpfo-templates-styles' ); ?></button>
				<button class="btn btn-secondary" id="survey-no"><?php esc_html_e( 'No', 'ubc-vpfo-templates-styles' ); ?></button>
			</div>
		</div>
		<div class="survey-action text-center mt-9 mt-md-5 d-none">
			<div class="survey-yes d-none"><?php echo wp_kses_post( $survey_yes ); ?></div>
			<div class="survey-no d-none"><?php echo wp_kses_post( $survey_no ); ?></div>
		</div>
	</section>
	<?php
}

unset( $display_survey );
?>