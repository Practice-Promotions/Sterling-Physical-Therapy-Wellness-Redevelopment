<?php
/**
* Job Posting functions and definitions and Meta related things.
*
* @package herostencilpt
*/

function jobs_register_cpts() {

	/**
	 * Post Type: Job Posting.
	 */
	$labels = [
		"name" => __( "Job Posting", "herostencilpt" ),
		"singular_name" => __( "Job Posting", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Job Posting", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
        "single" => true,
        "type" => "string",
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "jobs", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];
	register_post_type( "job", $args );
}
add_action( 'init', 'jobs_register_cpts' );

function add_job_meta_box() {
	add_meta_box(
		'job_meta_box',
		'Post: Job Posting',
		'display_job_meta_box',
		'job',
		'advanced',
		'high'
	);
}
add_action('add_meta_boxes', 'add_job_meta_box');

function display_job_meta_box($post) {
	global $editIcon;
	global $deleteIcon;

	/**  Add nonce for security and authentication */
   	wp_nonce_field('save_job_meta_box', 'job_meta_box_nonce');

   	$job_title = get_post_meta($post->ID, '_job_title', true);
   	$job_description = get_post_meta($post->ID, '_job_description', true);

	/** Tab: Hiring Orgaization var */
   	$job_hiring_organization_logo = get_post_meta($post->ID, '_job_hiring_organization_logo', true);
   	$job_hiring_organization = get_post_meta($post->ID, '_job_hiring_organization', true);
   	$job_hiring_organization_url = get_post_meta($post->ID, '_job_hiring_organization_url', true);

	$selected_option = get_post_meta($post->ID, '_job_hiring_type', true) ?: 'shortcode';
   	$job_hiring_form = get_post_meta($post->ID, '_job_hiring_form', true);
	$job_hiring_thirdparty_link = get_post_meta($post->ID, '_job_hiring_thirdparty_link', true);

	/** Tab: Orgaization Location var */
	$job_location_type = get_post_meta($post->ID, '_job_location_type', true);
	$job_street_address = get_post_meta($post->ID, '_job_street_address', true);
	$job_locality = get_post_meta($post->ID, '_job_locality', true);
	$job_postal_code = get_post_meta($post->ID, '_job_postal_code', true);
	$job_region = get_post_meta($post->ID, '_job_region', true);
	$job_country = get_post_meta($post->ID, '_job_country', true);
	$job_full_address = get_post_meta($post->ID, '_job_full_address', true);
	$job_location_map = get_post_meta($post->ID, '_job_location_map', true);


	/** Tab: Job Salary var */
	$job_salary_in_currency = get_post_meta($post->ID, '_job_salary_in_currency', true);
	$job_salary_per_unit = get_post_meta($post->ID, '_job_salary_per_unit', true);
	$job_base_salary = get_post_meta($post->ID, '_job_base_salary', true);
	$job_min_salary = get_post_meta($post->ID, '_job_min_salary', true);
	$job_max_salary = get_post_meta($post->ID, '_job_max_salary', true);

	/** Tab: Other Details var */
   	$job_date_posted = get_post_meta($post->ID, '_job_date_posted', true);
   	$job_valid_through = get_post_meta($post->ID, '_job_valid_through', true);
   	$job_industry = get_post_meta($post->ID, '_job_industry', true);
   	$job_employment_type = get_post_meta($post->ID, '_job_employment_type', true);
   	$job_work_hours = get_post_meta($post->ID, '_job_work_hours', true);
   	$job_experience = get_post_meta($post->ID, '_job_experience', true);
   	$job_education = get_post_meta($post->ID, '_job_education', true);
   	$job_qualifications = get_post_meta($post->ID, '_job_qualifications', true);
   	$job_responsibilities = get_post_meta($post->ID, '_job_responsibilities', true);
   	$job_skills = get_post_meta($post->ID, '_job_skills', true);
	$job_benefits = get_post_meta($post->ID, '_job_benefits', true);

	?>
	<div class="team-meta-box">
		<div class="default-tab-content">
			<div class="meta-field">
				<label for="job_title">Job Title (schema) <span style="color:red">*</span></label>
				<input type="text" name="job_title" id="job_title" value="<?php echo esc_attr($job_title); ?>" required />
			</div>
			<div class="meta-field">
				<label for="job_description">Description (schema) <span style="color:red">*</span></label>
				<textarea name="job_description" id="job_description" rows="5" required><?php echo wp_kses_post($job_description); ?></textarea>
			</div>
		</div>
		<div class="nav-tab-wrapper">
			<a href="#" class="nav-tab nav-tab-active" data-tab="hiring-organization">Hiring Organization</a>
			<a href="#" class="nav-tab" data-tab="organization-location">Organization Location</a>
			<a href="#" class="nav-tab" data-tab="job-salary">Job Salary</a>
			<a href="#" class="nav-tab" data-tab="other-details">Other Details</a>
		</div>
		<div id="hiring-organization" class="tab-content">
			<div class="meta-field">
				<label for="job_hiring_organization_logo">Job - Hiring Organization Logo</label>
				<div class="meta-image">
					<img id="job_hiring_organization_logo_preview" src="<?php echo esc_attr($job_hiring_organization_logo); ?>" style="max-width: 180px; height: auto; background:#f1f1f1;" />
					<div cass="action-item">
						<button type="button" class="action-icon edit" id="upload_logo_button"><?php echo $editIcon;?></button>
						<button type="button" class="action-icon delete" id="remove_logo_button"><?php echo $deleteIcon;?></button>
					</div>
				</div>
				<input type="hidden" name="job_hiring_organization_logo" id="job_hiring_organization_logo" value="<?php echo esc_attr($job_hiring_organization_logo); ?>" />
			</div>
			<div>
				<div class="meta-field">
					<label for="job_hiring_organization">Job - Hiring Organization (schema) <span style="color:red">*</span></label>
					<input type="text" name="job_hiring_organization" id="job_hiring_organization" value="<?php echo esc_attr($job_hiring_organization); ?>" required />
				</div>
				<div class="meta-field">
					<label for="job_hiring_organization_url">Job - Hiring Organization URL <span style="color:red">*</span></label>
					<input type="text" name="job_hiring_organization_url" id="job_hiring_organization_url" value="<?php echo esc_attr($job_hiring_organization_url); ?>" required />
				</div>
			</div>
			<div class="job-hiring-form-showhide">
				<div class="meta-field">
					<strong>Select Job Hiring Type:</strong><br>
					<label>
						<input type="radio" name="job_hiring_type" value="shortcode" <?php checked($selected_option, 'shortcode'); ?>>
						Job - Hiring Form Shortcode
					</label>
					<label>
						<input type="radio" name="job_hiring_type" value="thirdparty" <?php checked($selected_option, 'thirdparty'); ?>>
						Job - Hiring Thirdparty Link
					</label>
				</div>
				<div id="shortcode_field" class="meta-field">
					<label for="job_hiring_form">Job - Hiring Form Shortcode</label>
					<input type="text" name="job_hiring_form" id="job_hiring_form" value="<?php echo esc_attr($job_hiring_form); ?>" placeholder="[gravityform id='32' title='true' ajax='true']" />
				</div>
				<div id="thirdparty_link_field" class="meta-field" style="display: none;">
					<label for="job_hiring_thirdparty_link">Job - Hiring Thirdparty Link </label>
					<input type="text" name="job_hiring_thirdparty_link" id="job_hiring_thirdparty_link" value="<?php echo esc_attr($job_hiring_thirdparty_link); ?>" />
				</div>
			</div>
		</div>
		<div id="organization-location" class="tab-content" style="display:none;">
			<div class="meta-field">
				<label for="job_location_type">Job - Location Type (schema)</label>
				<input type="text" name="job_location_type" id="job_location_type" value="<?php echo esc_attr($job_location_type); ?>" />
			</div>
			<div>
				<div class="meta-field">
					<label for="job_street_address">Job - Street Address (schema) <span style="color:red">*</span></label>
					<input type="text" name="job_street_address" id="job_street_address" value="<?php echo esc_attr($job_street_address); ?>" required />
				</div>
				<div class="meta-field">
					<label for="job_full_address">Job - Full Address <span style="color:red">*</span></label>
					<input type="text" name="job_full_address" id="job_full_address" value="<?php echo esc_attr($job_full_address); ?>" required />
				</div>
				<div class="meta-field">
					<label for="job_location_map">Job - Location Map <span style="color:red">*</span></label>
					<input type="text" name="job_location_map" id="job_location_map" value="<?php echo esc_attr($job_location_map); ?>" required />
				</div>
				<div class="meta-field">
					<label for="job_locality">Job - Locality (schema) <span style="color:red">*</span></label>
					<input type="text" name="job_locality" id="job_locality" value="<?php echo esc_attr($job_locality); ?>" required />
				</div>
				<div class="meta-field">
					<label for="job_postal_code">Job - Postal Code (schema) <span style="color:red">*</span></label>
					<input type="text" name="job_postal_code" id="job_postal_code" value="<?php echo esc_attr($job_postal_code); ?>" required />
				</div>
			</div>
			<div>
				<div class="meta-field">
					<label for="job_region">Job - Region (schema) <span style="color:red">*</span></label>
					<input type="text" name="job_region" id="job_region" value="<?php echo esc_attr($job_region); ?>" required />
				</div>
				<div class="meta-field">
					<label for="job_country">Job - Country (schema) <span style="color:red">*</span></label>
					<input type="text" name="job_country" id="job_country" value="<?php echo esc_attr($job_country); ?>" required />
				</div>
			</div>
		</div>
		<div id="job-salary" class="tab-content" style="display:none;">
			<div>
				<div class="meta-field">
					<label for="job_salary_in_currency">Job - Salary In Currency</label>
					<input type="text" name="job_salary_in_currency" id="job_salary_in_currency" value="<?php echo esc_attr($job_salary_in_currency); ?>" />
				</div>
				<div class="meta-field">
					<label for="job_salary_per_unit">Job - Salary Per Unit (schema)</label>
					<input type="text" name="job_salary_per_unit" id="job_salary_per_unit" value="<?php echo esc_attr($job_salary_per_unit); ?>" />
				</div>
			</div>
			<div>
				<div class="meta-field">
					<label for="job_base_salary">Job - Base Salary (schema)</label>
					<input type="text" name="job_base_salary" id="job_base_salary" value="<?php echo esc_attr($job_base_salary); ?>" />
				</div>
				<div class="meta-field">
					<label for="job_min_salary">Job - Min Salary (schema)</label>
					<input type="text" name="job_min_salary" id="job_min_salary" value="<?php echo esc_attr($job_min_salary); ?>" />
				</div>
				<div class="meta-field">
					<label for="job_max_salary">Job - Max Salary (schema)</label>
					<input type="text" name="job_max_salary" id="job_max_salary" value="<?php echo esc_attr($job_max_salary); ?>" />
				</div>
			</div>
		</div>
		<div id="other-details" class="tab-content" style="display:none;">
			<div>
				<div class="meta-field">
					<label for="job_date_posted">Job - Date Posted (schema) - (YYYY-MM-DD) <span style="color:red">*</span></label>
					<input type="text" name="job_date_posted" id="job_date_posted" class="meta-datepicker" value="<?php echo esc_attr($job_date_posted); ?>" placeholder="Date format (YYYY-MM-DD)" required />
				</div>
				<div class="meta-field">
					<label for="job_valid_through">Job - Valid Through (schema) - (YYYY-MM-DD)</label>
					<input type="text" name="job_valid_through" id="job_valid_through" class="meta-datepicker" value="<?php echo esc_attr($job_valid_through); ?>" placeholder="Date format (YYYY-MM-DD)" />
				</div>
			</div>
			<div class="four-column">
				<div class="meta-field">
					<label for="job_industry">Job - Industry (schema)</label>
					<input type="text" name="job_industry" id="job_industry" value="<?php echo esc_attr($job_industry); ?>" />
				</div>
				<div class="meta-field">
				    <label for="job_employment_type">Job - Employment Type (schema)</label>
				    <select name="job_employment_type" id="job_employment_type">
				        <option value="FULL_TIME" <?php selected($job_employment_type, 'Full_Time'); ?>>FULL_TIME</option>
				        <option value="Part Time" <?php selected($job_employment_type, 'Part_Time'); ?>>Part Time</option>
				        <option value="Temporary" <?php selected($job_employment_type, 'Temporary'); ?>>Temporary</option>
				        <option value="Freelance" <?php selected($job_employment_type, 'Freelance'); ?>>Freelance</option>
				        <option value="Internship" <?php selected($job_employment_type, 'Internship'); ?>>Internship</option>
				    </select>
				</div>
				<div class="meta-field">
					<label for="job_work_hours">Job - Work Hours (schema)</label>
					<input type="text" name="job_work_hours" id="job_work_hours" value="<?php echo esc_attr($job_work_hours); ?>" />
				</div>
				<div class="meta-field">
					<label for="job_experience">Job - Experience (schema)</label>
					<input type="number" name="job_experience" id="job_experience" value="<?php echo esc_attr($job_experience); ?>" />
				</div>
			</div>
			<div class="meta-field">
				<label for="job_education">Job - Education (schema)</label>
				<input type="text" name="job_education" id="job_education" value="<?php echo esc_attr($job_education); ?>" />
			</div>
			<div class="meta-field">
				<label for="job_qualifications">Job - Qualifications (schema)</label>
				<textarea name="job_qualifications" id="job_qualifications" rows="5"><?php echo wp_kses_post($job_qualifications); ?></textarea>
			</div>
			<div class="meta-field">
				<label for="job_responsibilities">Job - Responsibilities (schema)</label>
				<textarea name="job_responsibilities" id="job_responsibilities" rows="5"><?php echo wp_kses_post($job_responsibilities); ?></textarea>
			</div>
			<div class="meta-field">
				<label for="job_skills">Job - Skills (schema)</label>
				<textarea name="job_skills" id="job_skills" rows="5"><?php echo wp_kses_post($job_skills); ?></textarea>
			</div>
			<div class="meta-field">
				<label for="job_benefits">Job - Benefits</label>
				<textarea name="job_benefits" id="job_benefits" rows="5"><?php echo wp_kses_post($job_benefits); ?></textarea>
			</div>
		</div>
	</div>
	<?php
}

function save_job_meta_box($post_id) {
    if (!isset($_POST['job_meta_box_nonce']) || !wp_verify_nonce($_POST['job_meta_box_nonce'], 'save_job_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

	if (array_key_exists('job_title', $_POST)) {
        update_post_meta($post_id, '_job_title', sanitize_text_field($_POST['job_title']));
    }
    if (array_key_exists('job_description', $_POST)) {
		update_post_meta($post_id, '_job_description', wp_kses_post($_POST['job_description']));
	}

	/** Save Hiring Orgaization fields */
    if (array_key_exists('job_hiring_organization_logo', $_POST)) {
        update_post_meta($post_id, '_job_hiring_organization_logo', sanitize_text_field($_POST['job_hiring_organization_logo']));
    }
    if (array_key_exists('job_hiring_organization', $_POST)) {
        update_post_meta($post_id, '_job_hiring_organization', sanitize_text_field($_POST['job_hiring_organization']));
    }
    if (array_key_exists('job_hiring_organization_url', $_POST)) {
        update_post_meta($post_id, '_job_hiring_organization_url', sanitize_text_field($_POST['job_hiring_organization_url']));
    }

	if (isset($_POST['job_hiring_type'])) {
        update_post_meta($post_id, '_job_hiring_type', sanitize_text_field($_POST['job_hiring_type']));
    }

    if (array_key_exists('job_hiring_form', $_POST)) {
        update_post_meta($post_id, '_job_hiring_form', sanitize_text_field($_POST['job_hiring_form']));
    }

	if (isset($_POST['job_hiring_thirdparty_link'])) {
        update_post_meta($post_id, '_job_hiring_thirdparty_link', esc_url($_POST['job_hiring_thirdparty_link']));
    }

	/** Save Orgaization Location fields */
    if (array_key_exists('job_location_type', $_POST)) {
        update_post_meta($post_id, '_job_location_type', sanitize_text_field($_POST['job_location_type']));
    }
    if (array_key_exists('job_street_address', $_POST)) {
        update_post_meta($post_id, '_job_street_address', sanitize_text_field($_POST['job_street_address']));
    }
    if (array_key_exists('job_locality', $_POST)) {
        update_post_meta($post_id, '_job_locality', sanitize_text_field($_POST['job_locality']));
    }
    if (array_key_exists('job_postal_code', $_POST)) {
        update_post_meta($post_id, '_job_postal_code', sanitize_text_field($_POST['job_postal_code']));
    }
    if (array_key_exists('job_region', $_POST)) {
        update_post_meta($post_id, '_job_region', sanitize_text_field($_POST['job_region']));
    }
	if (array_key_exists('job_country', $_POST)) {
        update_post_meta($post_id, '_job_country', sanitize_text_field($_POST['job_country']));
    }
	if (array_key_exists('job_full_address', $_POST)) {
        update_post_meta($post_id, '_job_full_address', sanitize_text_field($_POST['job_full_address']));
    }
	if (array_key_exists('job_location_map', $_POST)) {
        update_post_meta($post_id, '_job_location_map', sanitize_text_field($_POST['job_location_map']));
    }

	/** Save Job Salary fields */
    if (array_key_exists('job_salary_in_currency', $_POST)) {
        update_post_meta($post_id, '_job_salary_in_currency', sanitize_text_field($_POST['job_salary_in_currency']));
    }
    if (array_key_exists('job_salary_per_unit', $_POST)) {
        update_post_meta($post_id, '_job_salary_per_unit', sanitize_text_field($_POST['job_salary_per_unit']));
    }
    if (array_key_exists('job_base_salary', $_POST)) {
        update_post_meta($post_id, '_job_base_salary', sanitize_text_field($_POST['job_base_salary']));
    }
    if (array_key_exists('job_min_salary', $_POST)) {
        update_post_meta($post_id, '_job_min_salary', sanitize_text_field($_POST['job_min_salary']));
    }
    if (array_key_exists('job_max_salary', $_POST)) {
        update_post_meta($post_id, '_job_max_salary', sanitize_text_field($_POST['job_max_salary']));
    }

	/** Save Other Details fields */
    if (array_key_exists('job_date_posted', $_POST)) {
        update_post_meta($post_id, '_job_date_posted', sanitize_text_field($_POST['job_date_posted']));
    }
    if (array_key_exists('job_valid_through', $_POST)) {
        update_post_meta($post_id, '_job_valid_through', sanitize_text_field($_POST['job_valid_through']));
    }
    if (array_key_exists('job_industry', $_POST)) {
        update_post_meta($post_id, '_job_industry', sanitize_text_field($_POST['job_industry']));
    }
    if (array_key_exists('job_employment_type', $_POST)) {
        update_post_meta($post_id, '_job_employment_type', sanitize_text_field($_POST['job_employment_type']));
    }
    if (array_key_exists('job_work_hours', $_POST)) {
        update_post_meta($post_id, '_job_work_hours', sanitize_text_field($_POST['job_work_hours']));
    }
    if (array_key_exists('job_experience', $_POST)) {
        update_post_meta($post_id, '_job_experience', sanitize_text_field($_POST['job_experience']));
    }
    if (array_key_exists('job_education', $_POST)) {
        update_post_meta($post_id, '_job_education', sanitize_text_field($_POST['job_education']));
    }
    if (array_key_exists('job_qualifications', $_POST)) {
        update_post_meta($post_id, '_job_qualifications', wp_kses_post($_POST['job_qualifications']));
    }
    if (array_key_exists('job_responsibilities', $_POST)) {
        update_post_meta($post_id, '_job_responsibilities', wp_kses_post($_POST['job_responsibilities']));
    }
    if (array_key_exists('job_skills', $_POST)) {
        update_post_meta($post_id, '_job_skills', wp_kses_post($_POST['job_skills']));
    }
	if (array_key_exists('job_benefits', $_POST)) {
        update_post_meta($post_id, '_job_benefits', wp_kses_post($_POST['job_benefits']));
    }
}
add_action('save_post', 'save_job_meta_box');

function add_job_meta_to_rest_response($response, $post, $context) {
    if ($post->post_type === 'job') {
        $response->data['job_title'] = get_post_meta($post->ID, '_job_title', true);
        $response->data['job_description'] = get_post_meta($post->ID, '_job_description', true);

		/** Hiring Orgaization meta */
        $response->data['job_hiring_organization_logo'] = get_post_meta($post->ID, '_job_hiring_organization_logo', true);
        $response->data['job_hiring_organization'] = get_post_meta($post->ID, '_job_hiring_organization', true);
        $response->data['job_hiring_organization_url'] = get_post_meta($post->ID, '_job_hiring_organization_url', true);

		/** Hiring Type meta */
        $response->data['job_hiring_type'] = get_post_meta($post->ID, '_job_hiring_type', true);
        $response->data['job_hiring_type'] = get_post_meta($post->ID, '_job_hiring_type', true);
        $response->data['job_hiring_thirdparty_link'] = get_post_meta($post->ID, '_job_hiring_thirdparty_link', true);

		/** Orgaization Location meta */
        $response->data['job_location_type'] = get_post_meta($post->ID, '_job_location_type', true);
        $response->data['job_street_address'] = get_post_meta($post->ID, '_job_street_address', true);
		$response->data['job_full_address'] = get_post_meta($post->ID, '_job_full_address', true);
        $response->data['job_location_map'] = get_post_meta($post->ID, '_job_location_map', true);
        $response->data['job_locality'] = get_post_meta($post->ID, '_job_locality', true);
        $response->data['job_postal_code'] = get_post_meta($post->ID, '_job_postal_code', true);
        $response->data['job_region'] = get_post_meta($post->ID, '_job_region', true);
        $response->data['job_country'] = get_post_meta($post->ID, '_job_country', true);

		/** Job Salary meta */
        $response->data['job_salary_in_currency'] = get_post_meta($post->ID, '_job_salary_in_currency', true);
        $response->data['job_salary_per_unit'] = get_post_meta($post->ID, '_job_salary_per_unit', true);
        $response->data['job_base_salary'] = get_post_meta($post->ID, '_job_base_salary', true);
        $response->data['job_min_salary'] = get_post_meta($post->ID, '_job_min_salary', true);
        $response->data['job_max_salary'] = get_post_meta($post->ID, '_job_max_salary', true);

		/** Other Details meta */
        $response->data['job_date_posted'] = get_post_meta($post->ID, '_job_date_posted', true);
        $response->data['job_valid_through'] = get_post_meta($post->ID, '_job_valid_through', true);
        $response->data['job_industry'] = get_post_meta($post->ID, '_job_industry', true);
        $response->data['job_employment_type'] = get_post_meta($post->ID, '_job_employment_type', true);
        $response->data['job_work_hours'] = get_post_meta($post->ID, '_job_work_hours', true);
        $response->data['job_experience'] = get_post_meta($post->ID, '_job_experience', true);
        $response->data['job_education'] = get_post_meta($post->ID, '_job_education', true);
        $response->data['job_qualifications'] = get_post_meta($post->ID, '_job_qualifications', true);
        $response->data['job_responsibilities'] = get_post_meta($post->ID, '_job_responsibilities', true);
        $response->data['job_skills'] = get_post_meta($post->ID, '_job_skills', true);
		$response->data['job_benefits'] = get_post_meta($post->ID, '_job_benefits', true);
    }
    return $response;
}
add_filter('rest_prepare_job', 'add_job_meta_to_rest_response', 10, 3);