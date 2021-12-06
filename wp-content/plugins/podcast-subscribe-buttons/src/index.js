import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps, AlignmentToolbar, BlockControls, InspectorControls } from '@wordpress/block-editor';
import { ToggleControl, PanelBody, PanelRow, TextControl, CheckboxControl, SelectControl, ColorPicker } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import PostSelector from './postSelector';
import ServicesRepeater from './servicesRepeater';

registerBlockType( 'secondline-themes/podcast-subscribe-button', {
    apiVersion: 2,
    title: __('Podcast Subscribe Button', 'secondline-psb-custom-buttons'),
    icon: 'playlist-audio',
    category: 'design',
    attributes: {
        id: {
            type: 'integer',
        },
        use_saved_button: {
            type: 'integer',
            default: 0
        },
        secondline_psb_text: {
            type: 'string',
            default: 'Subscribe'
        },
        secondline_psb_select_type:{
            type: 'string',
            default: 'inline'
        },
        secondline_psb_select_style:{
            type: 'string',
            default: 'square'
        },
        secondline_psb_background_color:{
            type: 'string',
            default: '#000000'
        },
        secondline_psb_text_color:{
            type: 'string',
            default: '#ffffff'
        },
        secondline_psb_background_color_hover:{
            type: 'string',
            default: '#2a2a2a'
        },
        secondline_psb_text_color_hover:{
            type: 'string',
            default: '#ffffff'
        },
        secondline_psb_repeat_subscribe:{
            type: 'array',
            default: [
                {
                    secondline_psb_subscribe_platform: 'Acast',
                    secondline_psb_subscribe_url: 'https://',
                    secondline_psb_custom_link_label: __('sample','secondline-psb-custom-buttons')
                }
            ]
        },
        alignment: {
            type: 'string',
            default: 'none',
        }
    },
    edit: ( props ) => {
        const {attributes, setAttributes} = props;
        const onChangeAlignment = ( newAlignment ) => {
            setAttributes( {
                alignment: newAlignment === undefined ? 'none' : newAlignment,
            } );
        };

        return (
            <div { ...useBlockProps() }>
                {
                    <BlockControls>
                        <AlignmentToolbar
                            value={ attributes.alignment }
                            onChange={ onChangeAlignment }
                        />
                    </BlockControls>
                }
                <InspectorControls>
                    <PanelBody
                        title={__("Button Settings","secondline-psb-custom-buttons")}
                        initialOpen={true}
                    >
                        <PanelRow>
                            <ToggleControl
                                label={__("Use saved button","secondline-psb-custom-buttons")}
                                checked={attributes.use_saved_button === 1}
                                onChange={(newval) => setAttributes({ use_saved_button: newval ? 1 : 0 })}
                            />
                        </PanelRow>
                        {attributes.use_saved_button === 1 && <PanelRow>
                            <PostSelector selected={attributes.id} setSelectedPost={(value)=>{setAttributes({id:value})}}></PostSelector>
                        </PanelRow>}
                        {attributes.use_saved_button !== 1 &&(
                            <>
                                <PanelRow>
                                    <TextControl
                                        label={__("Button Text","secondline-psb-custom-buttons")}
                                        value={ attributes.secondline_psb_text }
                                        onChange={ ( value ) => setAttributes( { secondline_psb_text: value} ) }
                                    />
                                </PanelRow>
                                <PanelRow>
                                    <SelectControl
                                        label={__("Button Type","secondline-psb-custom-buttons")}
                                        value={ attributes.secondline_psb_select_type }
                                        options={ [
                                            { label: __('Modal / Pop-Up','secondline-psb-custom-buttons'), value: 'modal' },
                                            { label: __('Inline Buttons','secondline-psb-custom-buttons'), value: 'inline' },
                                            { label: __('List of Buttons','secondline-psb-custom-buttons'), value: 'list' },
                                            { label: __('Icons Only','secondline-psb-custom-buttons'), value: 'icons' },
                                        ] }
                                        onChange={ ( newtype ) => setAttributes( { secondline_psb_select_type: newtype } ) }
                                    />
                                </PanelRow>
                                <PanelRow>
                                    <SelectControl
                                        label={__("Button Style",'secondline-psb-custom-buttons')}
                                        value={ attributes.secondline_psb_select_style }
                                        options={ [
                                            { label: __('Square','secondline-psb-custom-buttons'), value: 'square' },
                                            { label: __('Rounded Saquare','secondline-psb-custom-buttons'), value: 'radius' },
                                            { label: __('Rounded','secondline-psb-custom-buttons'), value: 'round' },
                                        ] }
                                        onChange={ ( newstyle ) => setAttributes( { secondline_psb_select_style: newstyle } ) }
                                    />
                                </PanelRow>
                            </>
                        )}
                    </PanelBody>
                    {attributes.use_saved_button !== 1 &&(
                        <>
                            <PanelBody
                                title={__("Services",'secondline-psb-custom-buttons')}
                                initialOpen={false}
                            >
                                <ServicesRepeater repeat_subscribe={attributes.secondline_psb_repeat_subscribe} setAttributes={setAttributes}></ServicesRepeater>
                            </PanelBody>
                            <PanelBody
                                title={__("Background Color",'secondline-psb-custom-buttons')}
                                initialOpen={false}
                            >
                                <PanelRow>
                                    <ColorPicker
                                        color={ attributes.secondline_psb_background_color }
                                        onChangeComplete={ ( color ) => setAttributes( { secondline_psb_background_color: color.hex } ) }
                                    />
                                </PanelRow>
                            </PanelBody>
                            <PanelBody
                            title={__("Text Color",'secondline-psb-custom-buttons')}
                            initialOpen={false}
                            >
                                <PanelRow>
                                    <ColorPicker
                                        color={ attributes.secondline_psb_text_color }
                                        onChangeComplete={ ( color ) => setAttributes( { secondline_psb_text_color: color.hex } ) }
                                    />
                                </PanelRow>
                            </PanelBody>
                            <PanelBody
                            title={__("Hover Background Color",'secondline-psb-custom-buttons')}
                            initialOpen={false}
                            >
                                <PanelRow>
                                    <ColorPicker
                                        color={ attributes.secondline_psb_background_color_hover }
                                        onChangeComplete={ ( color ) => setAttributes( { secondline_psb_background_color_hover: color.hex } ) }
                                    />
                                </PanelRow>
                            </PanelBody>
                            <PanelBody
                            title={__("Hover Text Color",'secondline-psb-custom-buttons')}
                            initialOpen={false}
                            >
                                <PanelRow>
                                    <ColorPicker
                                        color={ attributes.secondline_psb_text_color_hover }
                                        onChangeComplete={ ( color ) => setAttributes( { secondline_psb_text_color_hover: color.hex } ) }
                                    />
                                </PanelRow>
                            </PanelBody>
                        </>
                    )}
                </InspectorControls>
                <ServerSideRender
                    block="secondline-themes/podcast-subscribe-button"
                    attributes={attributes}
                />
            </div>
        );
    }
} );
