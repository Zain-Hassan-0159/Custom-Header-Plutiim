<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Chp_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'chp';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Custom Header Plutiim', 'elementor-list-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-header';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'header', 'nav', 'custom header', 'plutiim' ];
	}

    private function get_menus(){
        // Get all menus
        $menus = wp_get_nav_menus();

        // Initialize an associative array to store menu names and IDs
        $menuArray = array();

        // Check if there are menus
        if ($menus) {
            // Loop through each menu and store name and ID in the associative array
            foreach ($menus as $menu) {
                $menuArray[$menu->term_id] = $menu->name;
            }
        } else {
            echo 'No menus found.';
        }

        // Return the associative array
        return $menuArray;
    }

	/**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'container_width',
			[
				'label' => esc_html__( 'Container Width', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 5,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 1200,
				],
				'selectors' => [
					'{{WRAPPER}} #primary_header .container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'select_menu',
			[
				'label' => esc_html__( 'Select Menu', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_menus(),
                'description' => __( 'IF there is no menu available then <a href="'.get_site_url(null, '/wp-admin/nav-menus.php?action=edit&menu=0').'">Create One</a>', 'textdomain' ),
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'link_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'textdomain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'website_link',
			[
				'label' => esc_html__( 'Link', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'responsive_links',
			[
				'label' => esc_html__( 'Responsive Links', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'link_title' => esc_html__( 'Project: Europees landbouwfounds', 'textdomain' ),
						'website_link' => esc_html__( '#', 'textdomain' ),
					],
					[
						'link_title' => esc_html__( 'Veelgestelde vragen', 'textdomain' ),
						'website_link' => esc_html__( '#', 'textdomain' ),
					],
				],
				'title_field' => '{{{ link_title }}}',
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'general_style_section',
			[
				'label' => esc_html__( 'General Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'header_background_color',
			[
				'label' => esc_html__( 'Header Background Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'devices' => [ 'mobile' ],
				'selectors' => [
                    '{{WRAPPER}} #primary_header' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .menu_open' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header ul.childs' => 'background-color: {{VALUE}}',

				],
			]
		);

        $this->add_responsive_control(
			'span_sup_color',
			[
				'label' => esc_html__( 'Small/Tiny Text Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .childs a span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header sup' => 'color: {{VALUE}}',

				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Top Menu Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'text_color_top',
			[
				'label' => esc_html__( 'Text Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .show_nav a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav button.close svg line' => 'stroke: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav button.normal svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .cart svg' => 'stroke: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_top',
                'label' => esc_html__( 'Text Typography', 'textdomain' ),
				'selector' => '{{WRAPPER}} #primary_header .show_nav a, {{WRAPPER}} #primary_header .show_nav button',
			]
		);


        $this->add_responsive_control(
			'text_color_top_hover',
			[
				'label' => esc_html__( 'Text Color Hover', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .show_nav a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav button.close:hover svg line' => 'stroke: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav button.normal:hover svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} #primary_header a:hover .cart svg' => 'stroke: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'cart_color_top',
			[
				'label' => esc_html__( 'Cart Counter Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .cart .items' => 'background-color: {{VALUE}}',
				],
			]
		);


        $this->end_controls_section();

        $this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__( 'Button Menu Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'text_color_button',
			[
				'label' => esc_html__( 'Text Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button.close svg line' => 'stroke: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button.normal svg path' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'button_color_button',
			[
				'label' => esc_html__( 'Button Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_button',
                'label' => esc_html__( 'Button Typography', 'textdomain' ),
				'selector' => '{{WRAPPER}} #primary_header .show_nav .menu_button button',
			]
		);

        $this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} #primary_header .show_nav .menu_button button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'button_radius',
			[
				'label' => esc_html__( 'Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} #primary_header .show_nav .menu_button button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'text_color_button_hover',
			[
				'label' => esc_html__( 'Text Color Hover', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button.close:hover svg line' => 'stroke: {{VALUE}}',
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button.normal:hover svg path' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'button_color_button_hover',
			[
				'label' => esc_html__( 'Button Color Hover', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} #primary_header .show_nav .menu_button button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'hidden_style_section',
			[
				'label' => esc_html__( 'Hidden Menu Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'text_color_lvlone',
			[
				'label' => esc_html__( 'Text Color Level 1', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .hidden_nav .parents a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_levelone',
                'label' => esc_html__( 'Text Typography Level 1', 'textdomain' ),
				'selector' => '{{WRAPPER}} #primary_header .hidden_nav .parents a',
			]
		);

        $this->add_responsive_control(
			'text_color_lvlone_hover',
			[
				'label' => esc_html__( 'Text Color Level 1 Hover', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .hidden_nav .parents a:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'text_color_lvltwo',
			[
				'label' => esc_html__( 'Text Color Level 2', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .hidden_nav .childs a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_leveltwo',
                'label' => esc_html__( 'Text Typography Level 2', 'textdomain' ),
				'selector' => '{{WRAPPER}} #primary_header .hidden_nav .childs a',
			]
		);

        $this->add_responsive_control(
			'text_color_lvltwo_hover',
			[
				'label' => esc_html__( 'Text Color Level 2 Hover', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .hidden_nav .childs a:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'text_color_responsive',
			[
				'label' => esc_html__( 'Responsive Bottom Text', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #primary_header .mobile_nav ul li a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography_levelresponsive',
                'label' => esc_html__( 'Responsive Bottom Text Typography', 'textdomain' ),
				'selector' => '{{WRAPPER}} #primary_header .mobile_nav ul li a',
			]
		);


        $this->end_controls_section();
	}

    private function get_child_counts($menu_items){
        // Create an associative array to store the count of child items for each parent item
        $child_counts = array();

        // Loop through each menu item
        if($menu_items){
            foreach ($menu_items as $menu_item) {
                // If the menu item has a parent ID, it is a child item
                if ($menu_item->menu_item_parent) {
                    // Increment the child count for the parent item
                    $parent_id = $menu_item->menu_item_parent;
                    if (isset($child_counts[$parent_id])) {
                        $child_counts[$parent_id]++;
                    } else {
                        $child_counts[$parent_id] = 1;
                    }
                }
            }
        }
        return $child_counts;
    }

	/**
	 * Render list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        $menuId = $settings['select_menu'];
        $menu_items = wp_get_nav_menu_items($menuId);
        // return array with ids and child counts of menu items which has more than or equal to 1 child
        $child_counts = $this->get_child_counts($menu_items);

        // echo "<pre>";
        // print_r($menu_items);
        ?>
        <style>

            #primary_header .show_nav, #primary_header .show_nav button {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none;
                outline: none;
            }

            #primary_header .logo img{
                max-height: 50px;
            }

            #primary_header .show_nav{
                padding: 40px 0;
            }

            #primary_header .show_nav button svg {
                height: 14px;
                width: 14px;
                margin-left: 10px;
            }


            #primary_header .show_nav button.close svg line{
                stroke: white;
            }

            #primary_header .show_nav button svg path{
                fill: white;
            }

            #primary_header .show_nav button {
                border-radius: 20px;
                background: #dc470f;
                color: white;
                font-weight: 600;
                padding: 8px 15px;
                transition: 0.4s all smooth;
            }

            #primary_header .menu_open {
                background: #2a3b22;
            }

            #primary_header .hidden_nav {
                display: flex;
                margin-top: 50px;
            }

            #primary_header ul.parents {
                flex: 1;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            #primary_header ul.childs {
                flex: 1;
                list-style: none;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding-left: 50px;
                border-left: 1px solid #ffffff40;;
            }

            #primary_header a {
                color: white;
                font-weight: 600;
            }

            #primary_header .hidden_nav a {
                padding: 3px 0;
                display: block;
                font-size: 25px;
            }

            #primary_header sup {
                font-size: 12px;
                font-weight: 400;
                color: #65725e;
                margin-left: 4px;
            }


            #primary_header .childs a {
                font-size: 18px;
                font-weight: 600;
            }

            #primary_header .childs a span {
                display: inline-block;
                margin-right: 20px;
                font-size: 12px;
                font-weight: 400;
                color: #65725e;
            }

            #primary_header .container{
                max-width: 1200px;
                width: 100%;
                margin: auto;
                position: relative;
                z-index: 99;
                padding: 0 30px;
            }

            #primary_header .hidden_nav_wrapper{
                position: absolute;
                width: 100%;
                height: 100%;
                bottom: 0;
                left: 0;
                top: 0;
                right: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                z-index: 90;
            }

            #primary_header .d-none{
                display: none !important;
            }

            #primary_header .active a {
                color: #879580;
            }

            #primary_header .hidden_nav li:hover a {
                color: #879580;
            }

            #primary_header .hidden_nav li{
                margin-bottom: 15px;
            }

            #primary_header .show_nav .shop a {
                display: flex;
                align-items: center;
            }

            #primary_header .shop span {
                margin-right: 10px;
            }

            #primary_header .cart {
                position: relative;
                height: 18px;
            }

            #primary_header .cart svg {
                width: 18px;
                height: 18px;
            }

            #primary_header .cart .items {
                position: absolute;
                top: -5px;
                right: -7px;
                background: #b30c0c;
                border-radius: 50%;
                width: 14px;
                height: 14px;
                font-size: 9px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #primary_header .backward,  #primary_header .mobile_nav {
                display: none;
            }


            @media(max-width: 500px){

                #primary_header .show_nav .logo {
                    order: 1;
                }

                #primary_header .show_nav .shop{
                    order: 2;
                }

                #primary_header .show_nav button {
                    border: none;
                    padding: 0;
                    background: none;
                }
                #primary_header .show_nav button span{
                    display: none;
                }
                #primary_header .show_nav{
                    padding: 20px 0;
                }
                #primary_header{
                    background: #2a3b22;
                }
                #primary_header .show_nav button svg{
                    height: 18px;
                    width: 18px;
                    margin-left: 0;
                }

                #primary_header .shop span{
                    display: none;
                }

                #primary_header .hidden_nav {
                    display: block;
                    position: relative;
                    margin: 30px 0 0;
                }

                #primary_header ul.parents {
                    border: none;
                    margin: 0;
                    text-align: center;
                }

                #primary_header .hidden_nav a {
                    font-size: 18px;
                }

                #primary_header ul.childs {
                    position: absolute;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    text-align: center;
                    background: #2a3b22;   
                    padding: 0;    
                    border: none;         
                }

                #primary_header .backward .text {
                    font-size: 18px;
                    font-weight: 600;
                    color: #65725e;
                }

                #primary_header svg.feather.feather-arrow-left {
                    float: left;
                    transform: translateY(7px);                
                }

                #primary_header svg.feather.feather-arrow-left path{
                    fill: #65725e;
                }

                #primary_header .backward {
                    padding: 30px;
                    width: 100%;
                    text-align: center;
                    display: initial;
                }

                #primary_header .hidden_nav_wrapper{
                    justify-content: space-between;
                    padding-top: 80px;
                    padding-bottom: 60px;
                }

                #primary_header .childs a span{
                    display: none;
                }

                #primary_header .mobile_nav{
                    display: block;
                }

                #primary_header .mobile_nav ul {
                    padding: 0;
                    text-align: center;
                    list-style: none;
                }

                #primary_header .mobile_nav ul li a {
                    font-size: 14px;
                    font-weight: 400;
                    color: #65725e;
                }

                #primary_header .hidden_nav_wrapper .container{
                    margin: 0;
                    text-align: center;
                }
            }
        </style>
        <header id="primary_header">
            <div class="container">
                <nav class="show_nav">
                    <div class="logo">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        
                        if ($custom_logo_id) {
                            $logo_img = wp_get_attachment_image_src($custom_logo_id, 'full');
                            echo '<a href="' . home_url('/') . '"><img src="' . esc_url($logo_img[0]) . '" alt="' . get_bloginfo('name') . '"></a>';
                        } else {
                            echo '<a href="' . home_url('/') . '">' . get_bloginfo('name') . '</a>';
                        }
                        ?>
                    </div>
                    <div class="menu_button">
                        <button class="normal"><span>Menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25.455" height="17.913" viewBox="0 0 25.455 17.913">
                                <g class="menuicon" data-name="Group 720" transform="translate(-296.223 -23)">
                                    <path class="Line_25" data-name="Line 25" d="M22.541,1.328H-.086A1.414,1.414,0,0,1-1.5-.086,1.414,1.414,0,0,1-.086-1.5H22.541A1.414,1.414,0,0,1,23.955-.086,1.414,1.414,0,0,1,22.541,1.328Z" transform="translate(297.723 32.043)" fill="#eae9e5"/>
                                    <path class="Line_26" data-name="Line 26" d="M11.228,1.328H-.086A1.414,1.414,0,0,1-1.5-.086,1.414,1.414,0,0,1-.086-1.5H11.228A1.414,1.414,0,0,1,12.642-.086,1.414,1.414,0,0,1,11.228,1.328Z" transform="translate(297.723 24.5)" fill="#eae9e5"/>
                                    <path class="Line_27" data-name="Line 27" d="M11.228,1.328H-.086A1.414,1.414,0,0,1-1.5-.086,1.414,1.414,0,0,1-.086-1.5H11.228A1.414,1.414,0,0,1,12.642-.086,1.414,1.414,0,0,1,11.228,1.328Z" transform="translate(309.035 39.585)" fill="#eae9e5"/>
                                </g>
                            </svg>
                        </button>
                        <button class="close d-none"><span>Menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.557" height="15.556" viewBox="0 0 15.557 15.556">
                                <g id="Group_720" data-name="Group 720" transform="translate(-301.17 -23.707)">
                                    <line id="Line_25" data-name="Line 25" x2="16" transform="translate(303.291 25.828) rotate(45)" fill="none" stroke="#eae9e5" stroke-linecap="round" stroke-width="3"/>
                                    <line id="Line_47" data-name="Line 47" x2="16" transform="translate(314.605 25.828) rotate(135)" fill="none" stroke="#eae9e5" stroke-linecap="round" stroke-width="3"/>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <div class="shop">
                        <a href="#">
                            <span>Webshop</span>
                            <div class="cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                <div class="items">0</div>
                            </div>
                        </a>
                    </div>
                </nav>    
            </div>
            <nav class="hidden_nav_wrapper d-none">
                <div class="container">
                    <div class="backward d-none">
                        <a href="#">              
                            <svg xmlns="http://www.w3.org/2000/svg" class="feather feather-arrow-left" width="16" height="11.2" viewBox="0 0 16 11.2">
                            <path id="Icon_ionic-ios-arrow-round-forward" data-name="Icon ionic-ios-arrow-round-forward" d="M13.671,11.466a.789.789,0,0,1,.006,1.073L10.3,16.092h12.86a.759.759,0,0,1,0,1.517H10.3l3.379,3.552a.8.8,0,0,1-.006,1.073.7.7,0,0,1-1.017-.006L8.081,17.387h0a.856.856,0,0,1-.15-.239.755.755,0,0,1-.056-.292.78.78,0,0,1,.206-.531l4.579-4.841A.685.685,0,0,1,13.671,11.466Z" transform="translate(-7.875 -11.252)" fill="#c6cfb7"/>
                            </svg>

                            <span class="text"></span>
                        </a>
                    </div>
                    <div class="hidden_nav">
                        <?php
                        if(!empty($menu_items)) :
                        ?>
                        <ul class="parents">
                            <?php 
                            foreach($menu_items as $item) : 
                                if($item->menu_item_parent == 0) :
                                    ?>
                                    <li data-target="<?php echo 'target_' .$item->ID; ?>"><a href="<?php echo $item->url; ?>"><span class="title"><?php echo $item->title; ?></span><?php echo isset($child_counts[$item->ID]) ? '<sup>(' .$child_counts[$item->ID]. ')</sup>' : ''; ?></a></li>
                                    <?php 
                                endif;
                            endforeach; 
                            ?>
                        </ul>
                        <ul class="childs d-none">
                            <?php 
                                $count = 1;
                                $old_id = -1;
                                foreach($menu_items as $item) : 
                                    if($item->menu_item_parent) :
                                        if($item->menu_item_parent !== $old_id){
                                            $count = 1;
                                            $old_id = $item->menu_item_parent;
                                        }
                                        ?>
                                        <li  class="<?php echo 'target_' .$item->menu_item_parent; ?> d-none"><a href="<?php echo $item->url; ?>"><span><?php echo $count; ?></span><?php echo $item->title; ?></a></li>
                                        <?php 
                                    endif;
                                    $count++;
                                endforeach; 
                            ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <nav class="mobile_nav">
                    <?php
                        if ( $settings['responsive_links'] ) {
                            echo '<ul>';
                            foreach (  $settings['responsive_links'] as $item ) {
                                ?>
                                    <li><a href="<?php echo $item['website_link']['url']; ?>"><?php echo $item['link_title']; ?></a></li>
                                <?php
                            }
                            echo '</ul>';
                        }
                    ?>
                </nav> 
            </nav>
        </header>
        <script>
            jQuery(document).ready(function ($) {
                const primaryHeader = $("#primary_header");
                const hiddenNavWrapper = primaryHeader.find(".hidden_nav_wrapper");
                const buttonNormal = primaryHeader.find("button.normal");
                const buttonClose = primaryHeader.find("button.close");
                const hiddenNavParentsLi = primaryHeader.find(".hidden_nav .parents li");
                const hiddenNavChildsLi = primaryHeader.find(".hidden_nav .childs li");
                const hiddenNavChilds = primaryHeader.find(".hidden_nav .childs");
                const backwardText = primaryHeader.find(".backward a .text");
                const backward = primaryHeader.find(".backward");



                buttonNormal.on("click", function () {
                    $(this).addClass("d-none");
                    primaryHeader.addClass("menu_open");
                    hiddenNavWrapper.addClass("menu_open");
                    buttonClose.removeClass("d-none");
                    hiddenNavWrapper.removeClass("d-none");
                });

                buttonClose.on("click", function () {
                    $(this).addClass("d-none");
                    $(".menu_open").removeClass("menu_open");
                    buttonNormal.removeClass("d-none");
                    hiddenNavWrapper.addClass("d-none");
                });

                hiddenNavParentsLi.on("click", function () {
                    const childSelector = $(this).data("target");
                    hiddenNavParentsLi.removeClass('active');
                    hiddenNavChildsLi.addClass('d-none');
                    hiddenNavChilds.removeClass('d-none');
                    backwardText.html($(this).find('a .title').text());
                    backward.removeClass('d-none');
                    $(this).addClass('active');
                    $(`.hidden_nav .childs .${childSelector}`).removeClass('d-none');
                });

                backward.on("click", function () {
                    hiddenNavParentsLi.removeClass('active');
                    hiddenNavChilds.addClass('d-none');
                    backward.addClass('d-none');
                });
            });

        </script>
		<?php
	}

}