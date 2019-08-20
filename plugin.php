<?php
/**
 * Class Moo_Action_After_Submit
 * @see https://developers.elementor.com/custom-form-action/
 * Custom elementor form action after submit to add a subsciber to
 * Moosend list via API
 */
class Moo_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {
	/**
	 * Get Name
	 *
	 * Return the action name
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'moosend';
	}

	/**
	 * Get Label
	 *
	 * Returns the action label
	 *
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return __( 'Moosend', 'text-domain' );
	}

	/**
	 * Run
	 *
	 * Runs the action after submit
	 *
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		//  Make sure that there is a Moosend API key
		if ( empty( $settings['moosend_api_key'] ) ) {
			return;
		}

		//  Make sure that there is a Moosend list ID
		if ( empty( $settings['moosend_list'] ) ) {
			return;
		}

		// Make sure that there is a Moosend Email field ID
		// which is required by Moosend's API to subsribe a user
		if ( empty( $settings['moosend_email_field'] ) ) {
			return;
		}

		// Get submitted Form data
		$raw_fields = $record->get( 'fields' );

		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Make sure that the user entered an email
		// which is required by Moosend's API to subscribe a user
		if ( empty( $fields[ $settings['moosend_email_field'] ] ) ) {
			return;
		}
		$customOne = "{$settings['moosend_custom_field_1_name']}={$fields[ $settings['moosend_custom_field_1'] ]}";
		$customTwo = "{$settings['moosend_custom_field_2_name']}={$fields[ $settings['moosend_custom_field_2'] ]}";
		$customThree = "{$settings['moosend_custom_field_3_name']}={$fields[ $settings['moosend_custom_field_3'] ]}";
    $customFour = "{$settings['moosend_custom_field_4_name']}={$fields[ $settings['moosend_custom_field_4'] ]}";
    $customFive = "{$settings['moosend_custom_field_5_name']}={$fields[ $settings['moosend_custom_field_5'] ]}";

		$DynamicCustomFields = [
			$customOne,
      $customTwo,
      $customThree,
      $customFour,
      $customFive
		];

		if ( isset( $settings['moosend_custom_field_1'] ) && ! empty( $settings['moosend_custom_field_1'] ) ) {
			$moosend_data['CustomFields'] = explode( ',', $DynamicCustomFields );
		}


		// If we got this far we can start building our request data
		// Based on the param list at https://moosendapp.docs.apiary.io/
		$moosend_data = [
            'name' => $fields[ $settings['moosend_name_field'] ],
			'email' => $fields[ $settings['moosend_email_field'] ],
            'CustomFields' => $DynamicCustomFields
		];

		// add name if field is mapped
		if ( empty( $fields[ $settings['moosend_name_field'] ] ) ) {
			$moosend_data['name'] = $fields[ $settings['moosend_name_field'] ];
		}


        $moosend_url = 'https://api.moosend.com/v3/subscribers/';
        $endpoint = $moosend_url . $settings['moosend_list'] . '/subscribe.json/' . '?apikey=' . $settings['moosend_api_key'];
		// Send the request
		wp_remote_post( $endpoint, array(
		    'headers' => array('Content-Type' => 'application/json', 'accept' => 'application/json'),
            'body' => json_encode($moosend_data),
            ));
	}

	/**
	 * Register Settings Section
	 *
	 * Registers the Action controls
	 *
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_moosend',
			[
				'label' => __( 'Moosend', 'text-domain' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'moosend_api_key',
			[
				'label' => __( 'Moosend API Key', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'a589366a-1a34-XXXX-XXXX-XXXXXXXXXXXX',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter your API Key', 'text-domain' ),
			]
		);

		$widget->add_control(
			'moosend_list',
			[
				'label' => __( 'Moosend List ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'separator' => 'before',
				'description' => __( 'the list id you want to subscribe a user to. This encrypted & hashed id can be found under View all lists section named ID.', 'text-domain' ),
			]
		);

		$widget->add_control(
			'moosend_email_field',
			[
				'label' => __( 'Email Field ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->add_control(
			'moosend_name_field',
			[
				'label' => __( 'Name Field ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $widget->add_control(
            'moosend_custom_field_1_name',
            [
                'label' => __( 'Custom Field 1 name', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'separator' => 'before',
                'description' => __( 'Place the Name of the Moosend Field', 'text-domain' ),
            ]
        );
        $widget->add_control(
            'moosend_custom_field_1',
            [
                'label' => __( 'Custom Field 1', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the ID of the Elementor Field', 'text-domain' ),
            ]
        );

        $widget->add_control(
            'moosend_custom_field_2_name',
            [
                'label' => __( 'Custom Field 2 name', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'separator' => 'before',
                'description' => __( 'Place the Name of the Moosend Field', 'text-domain' ),
            ]
        );
        $widget->add_control(
            'moosend_custom_field_2',
            [
                'label' => __( 'Custom Field 2', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the ID of the Elementor Field', 'text-domain' ),
            ]
        );

        $widget->add_control(
            'moosend_custom_field_3_name',
            [
                'label' => __( 'Custom Field 3 name', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'separator' => 'before',
                'description' => __( 'Place the Name of the Moosend Field', 'text-domain' ),
            ]
        );
        $widget->add_control(
            'moosend_custom_field_3',
            [
                'label' => __( 'Custom Field 3', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the ID of the Elementor Field', 'text-domain' ),
            ]
        );

        $widget->add_control(
            'moosend_custom_field_4_name',
            [
                'label' => __( 'Custom Field 4 name', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'separator' => 'before',
                'description' => __( 'Place the Name of the Moosend Field', 'text-domain' ),
            ]
        );
        $widget->add_control(
            'moosend_custom_field_4',
            [
                'label' => __( 'Custom Field 4', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the ID of the Elementor Field', 'text-domain' ),
            ]
        );

        $widget->add_control(
            'moosend_custom_field_5_name',
            [
                'label' => __( 'Custom Field 5 name', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'separator' => 'before',
                'description' => __( 'Place the Name of the Moosend Field', 'text-domain' ),
            ]
        );
        $widget->add_control(
            'moosend_custom_field_5',
            [
                'label' => __( 'Custom Field 5', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Place the ID of the Elementor Field', 'text-domain' ),
            ]
        );

		$widget->end_controls_section();

	}

	/**
	 * On Export
	 *
	 * Clears form settings on export
	 * @access Public
	 * @param array $element
	 */
	public function on_export( $element ) {
		unset(
			$element['moosend_api_key'],
			$element['moosend_list'],
			$element['moosend_name_field'],
			$element['moosend_email_field'],
            $element['moosend_custom_field_1'],
            $element['moosend_custom_field_2'],
            $element['moosend_custom_field_3'],
            $element['moosend_custom_field_4'],
            $element['moosend_custom_field_5']
		);
	}
}
add_action( 'elementor_pro/init', function() {
// Here its safe to include our action class file
include_once( 'mooelements.php' );

// Instantiate the action class
$moosend_action = new Moo_Action_After_Submit();

// Register the action with form widget
\ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $moosend_action->get_name(), $moosend_action );
});
