<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class MPT_Portfolio extends Widget_Base {

    public function get_name() {
        return 'mpt-portfolio';
    }

    public function get_title() {
        return esc_html__( 'Mechlin Portfolio', 'mechlin-portfolio' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array( 'mechlin-portfolio' );
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_portfolio_items',
            [
                'label' => esc_html__( 'Portfolio Items', 'mechlin-portfolio' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Title', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Portfolio Title' , 'mechlin-portfolio' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'featured_image', [
                'label' => esc_html__( 'Featured Image', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'type', [
                'label' => esc_html__( 'Type', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'show_label' => true,
                'default' => 'image',
                'options' => [
                    'image' => [
                        'title' => esc_html__( 'Image', 'elementor' ),
                        'icon' => 'eicon-image',
                    ],
                    'video' => [
                        'title' => esc_html__( 'Video', 'elementor' ),
                        'icon' => 'eicon-video-camera',
                    ],
                    'audio' => [
                        'title' => esc_html__( 'Audio', 'elementor' ),
                        'icon' => 'eicon-headphones',
                    ],
                ] 
            ]
        );

        $repeater->add_control(
            'images', [
                'label' => esc_html__( 'Add Images', 'mechlin-portfolio' ),
                'type' => Controls_Manager::GALLERY,
                'show_label' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'type' => 'image'
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'gallery', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude' => [ 'custom' ],
                'include' => [],
                'default' => 'large',
                'condition' => [
                    'type' => 'image'
                ]
            ]
        );

        $repeater->add_control(
            'video', [
                'label' => esc_html__( 'Youtube Video URL', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::URL,
                'label_block' => true,
                'show_external' => false,
                'default' => [
                    'url' => 'https://www.youtube.com/watch?v=2OEL4P1Rz04'
                ],
                'condition' => [
                    'type' => 'video'
                ]
            ]
        );

        $repeater->add_control(
            'audio', [
                'label' => esc_html__( 'SoundCloud URL', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::URL,
                'label_block' => true,
                'show_external' => false,
                'default' => [
                    'url' => 'https://soundcloud.com/bmsharp/you-and-yours-acle-kahney-remix'
                ],
                'condition' => [
                    'type' => 'audio'
                ]
            ]
        );

        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Content', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'show_label' => true,
            ]
        );

        $repeater->add_control(
            'date', [
                'label' => esc_html__( 'Date', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'services', [
                'label' => esc_html__( 'Services', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'client', [
                'label' => esc_html__( 'Client', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'show_excerpt',
            [
                'label' => esc_html__( 'Show Excerpt', 'mechlin-portfolio' ),
                'description' => esc_html__( 'If enable this option, it will display 50 words of the content as the excerpt.', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'mechlin-portfolio' ),
                'label_off' => esc_html__( 'No', 'mechlin-portfolio' ),
                'return_value' => 1,
                'default' => 0
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__( 'Portfolio Item', 'mechlin-portfolio' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'text' => esc_html__( 'Item #1', 'mechlin-portfolio' ),
                    ]
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_portfolio_layout',
            [
                'label' => esc_html__( 'Layout', 'mechlin-portfolio' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'columns', [
                'label' => esc_html__( 'Columns', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'show_label' => true,
                'default' => '3',
                
                'options' => [
                    '2' => esc_html__( '2 Columns', 'mechlin-portfolio' ),
                    '3' => esc_html__( '3 Columns', 'mechlin-portfolio' ),
                    '4' => esc_html__( '4 Columns', 'mechlin-portfolio' ),
                    '5' => esc_html__( '5 Columns', 'mechlin-portfolio' ),
                ]
            ]
        );

        $this->add_control(
            'title_position', [
                'label' => esc_html__( 'Title Position', 'mechlin-portfolio' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'show_label' => true,
                'default' => 'outside',
                'options' => [
                    'outside' => esc_html__( 'Outside The Box', 'mechlin-portfolio' ),
                    'inside' => esc_html__( 'Inside The Box', 'mechlin-portfolio' ),
                ]
            ]
        );

        $this->add_responsive_control(
            'featured_image_height',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Featured Image Height', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item .grid-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 250,
                ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ]
                ]
            ]
        );
        
        $this->add_responsive_control(
            'grid_item_height',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Grid Height', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'size' => 250,
                ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 600,
                        'step' => 1,
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'grid_item_grap',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Columns Gap', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item' => 'margin: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
                    '{{WRAPPER}} .mpt-portfolio.columns-2 .grid-item' => 'width: calc(1/2*100% - (1 - 1/2)*{{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .mpt-portfolio.columns-3 .grid-item' => 'width: calc(1/3*100% - (1 - 1/3)*{{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .mpt-portfolio.columns-4 .grid-item' => 'width: calc(1/4*100% - (1 - 1/4)*{{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .mpt-portfolio.columns-5 .grid-item' => 'width: calc(1/5*100% - (1 - 1/5)*{{SIZE}}{{UNIT}});'
                ],
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_portfolio_data',
            [
                'label' => esc_html__( 'Data', 'mechlin-portfolio' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_infinite_scroll',
            [
                'label' => esc_html__( 'Enable Infinite Scroll', 'mechlin-portfolio' ),
                'description' => esc_html__( 'If enable Infinite scroll, you should only add one portfolio widget per page.', 'mechlin-portfolio' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'mech-portfolio' ),
                'label_off' => esc_html__( 'No', 'mech-portfolio' ),
                'return_value' => '1',
                'default' => '0'
            ]
        );

        $this->add_control(
            'items_per_page',
            [
                'type' => Controls_Manager::NUMBER,
                'label' => esc_html__( 'Number Items Per Page', 'mechlin-portfolio' ),
                'min' => 2,
                'max' => 100,
                'step' => 1,
                'default' => 6
            ]
        );

         $this->end_controls_section();

        $this->start_controls_section(
            'section_portfolio_grid_style',
            [
                'label' => esc_html__( 'Grid View', 'mechlin-portfolio' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(

            'outside_title_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__( 'Title Color', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item .grid-title' => 'color: {{VALUE}};',
                ],
                'description'  =>  esc_html__( 'Change the title color which outside the box.', 'mechlin-portfolio' ),
                'default' => '',
                'condition' => [
                    'title_position' => 'outside',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'outside_title_typography',
                'label' => esc_html__( 'Title Typography', 'mechlin-portfolio' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .mpt-portfolio .grid-item .grid-title',
                'condition' => [
                    'title_position' => 'outside',
                ],
            ]
        );

        $this->add_control(

            'outside_excerpt_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__( 'Excerpt Color', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item .excerpt' => 'color: {{VALUE}};',
                ],
                'description'  =>  esc_html__( 'Change the excerpt color which outside the box.', 'mechlin-portfolio' ),
                'default' => '',
                'condition' => [
                    'title_position' => 'outside',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'outside_excerpt_typography',
                'label' => esc_html__( 'Excerpt Typography', 'mechlin-portfolio' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .mpt-portfolio .grid-item .excerpt',
                'condition' => [
                    'title_position' => 'outside',
                ],
            ]
        );

        $this->add_control(

            'inside_title_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__( 'Title Color', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item .grid-thumbnail .grid-title' => 'color: {{VALUE}};',
                ],
                'description'  =>  esc_html__( 'Change the title color which inside the box.', 'mechlin-portfolio' ),
                'default' => '',
                'condition' => [
                    'title_position' => 'inside',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'inside_title_typography',
                'label' => esc_html__( 'Title Typography', 'mechlin-portfolio' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .mpt-portfolio .grid-item .grid-thumbnail .grid-title',
                'condition' => [
                    'title_position' => 'inside',
                ],
            ]
        );

        $this->add_control(

            'inside_excerpt_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__( 'Excerpt Color', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item .grid-thumbnail .excerpt' => 'color: {{VALUE}};',
                ],
                'description'  =>  esc_html__( 'Change the excerpt color which inside the box.', 'mechlin-portfolio' ),
                'default' => '#fff',
                'condition' => [
                    'title_position' => 'inside',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'inside_excerpt_typography',
                'label' => esc_html__( 'Excerpt Typography', 'mechlin-portfolio' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .mpt-portfolio .grid-item .grid-thumbnail .excerpt',
                'condition' => [
                    'title_position' => 'inside',
                ],
            ]
        );

        $this->add_control(

            'grid_overlay_color',
            [
                'type' => Controls_Manager::COLOR,
                'label' => esc_html__( 'Grid Overlay Color', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio .grid-item .grid-overlay' => 'background-color: {{VALUE}};',
                ],
                'description'  =>  esc_html__( 'Change the overlay color which inside the box.', 'mechlin-portfolio' ),
                'default' => '',
                'condition' => [
                    'title_position' => 'inside',
                ],
            ]
        );

        $this->add_control(
            'grid_overlay_opacity',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Grid Overlay Opacity', 'mechlin-portfolio' ),
                'selectors' => [
                    '{{WRAPPER}} .mpt-portfolio.grid-layout .grid-item .grid-thumbnail .grid-overlay' => 'opacity: {{SIZE}};',
                ],
                'default' => [
                    'size' => 0.2,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ]
                ],
                'condition' => [
                    'title_position' => 'inside',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $data = (array)$this->get_settings();
        $data['id'] = $this->get_id();
        ob_start();
        mpt_load_template( self::get_name(), '', (object)$data );
        echo ob_get_clean();
    }

    protected function _content_template() {
        
    }

}
