import { ToggleControl, PanelBody, PanelRow, TextControl, CheckboxControl, SelectControl, ColorPicker, Button, Card, CardBody } from '@wordpress/components';
const { element: { useState } } = wp;
import { __ } from '@wordpress/i18n';

const ServicesRepeater = ({repeat_subscribe, setAttributes}) => {
    //const [services, setServices] = useState(repeat_subscribe);
    const handleServiceChange = ( index, event ) => {
        if ( undefined == event ) {
            return;
        }
        let the_services = [...repeat_subscribe];
        if ( the_services.length == 0 ) {
            return;
        }

        the_services[index] = { secondline_psb_subscribe_platform: event || '', secondline_psb_subscribe_url: the_services[index].secondline_psb_subscribe_url || '', secondline_psb_custom_link_label: the_services[index].secondline_psb_custom_link_label || '' };
        setAttributes({secondline_psb_repeat_subscribe: the_services});
    };
    const handleLinkChange = ( index, event ) => {
        if ( undefined == event ) {
            return;
        }
        let the_services = [...repeat_subscribe];
        if ( the_services.length == 0 ) {
            return;
        }

        the_services[index] = { secondline_psb_subscribe_platform: the_services[index].secondline_psb_subscribe_platform || '', secondline_psb_subscribe_url: event || '', secondline_psb_custom_link_label: the_services[index].secondline_psb_custom_link_label || '' };
        setAttributes({secondline_psb_repeat_subscribe: the_services});
    };
    const handleCustomLabelChange = ( index, event ) => {
        if ( undefined == event ) {
            return;
        }
        let the_services = [...repeat_subscribe];
        if ( the_services.length == 0 ) {
            return;
        }
        the_services[index] = { secondline_psb_subscribe_platform: the_services[index].secondline_psb_subscribe_platform || '', secondline_psb_subscribe_url: the_services[index].secondline_psb_subscribe_url || '', secondline_psb_custom_link_label: event || '' };

        setAttributes({secondline_psb_repeat_subscribe: the_services});
    };
    const handleDelete = ( index, event ) => {
        let the_services = [...repeat_subscribe];
        the_services.splice(index,1);
        // Have at least 1 service
        if( the_services.length == 0 ) {
            the_services = [{
                secondline_psb_subscribe_platform: 'Acast',
                secondline_psb_subscribe_url: 'https://',
                secondline_psb_custom_link_label: 'sample'
            }];
        }
        setAttributes( { secondline_psb_repeat_subscribe: the_services } );
    };
    const handleAdd = (  event ) => {
        let the_services = [...repeat_subscribe];
        the_services.push({
            secondline_psb_subscribe_platform: 'Acast',
            secondline_psb_subscribe_url: 'https://',
            secondline_psb_custom_link_label: 'label'
        });
        setAttributes( { secondline_psb_repeat_subscribe: the_services } );
    };
    return <>
        {repeat_subscribe.map((service, index) => {
            return <Card size="small">
                <CardBody>
                    <PanelRow>
                        <SelectControl
                            label={__("Subscribe Platform",'secondline-psb-custom-buttons')}
                            value={ service.secondline_psb_subscribe_platform }
                            options={ [
                                { label: 'Acast', value: 'Acast' },
                                { label: 'Amazon Alexa', value: 'Amazon-Alexa' },
                                { label: 'Amazon Music', value: 'Amazon-Music' },
                                { label: 'Anchor', value: 'Anchor' },
                                { value: 'Apple-Podcasts', label: 'Apple Podcasts'},
                                { value: 'Blubrry',  label: 'Blubrry'},
                                { value: 'Breaker', label: 'Breaker'},
                                { value: 'Bullhorn', label: 'Bullhorn'},
                                { value: 'CastBox', label: 'Castbox'},
                                { value: 'Castro', label:  'Castro'},
                                { value: 'Deezer', label: 'Deezer'},
                                { value: 'Downcast', label: 'Downcast'},
                                { value: 'fyyd.de', label: 'fyyd.de'},
                                { value: 'Gaana', label: 'Gaana'},
                                { value: 'Google-Play', label: 'Google Play'},
                                { value: 'Google-Podcasts', label:'Google Podcasts'},
                                { value: 'Himalaya.com' , label:  'Himalaya.com'},
                                { value: 'iHeartRadio' , label:  'iHeartRadio'},
                                { value: 'iTunes' , label:  'iTunes'},
                                { value: 'iVoox' , label:  'iVoox'},
                                { value: 'Laughable' , label:  'Laughable'},
                                { value: 'Libsyn' , label:  'Libsyn'},
                                { value: 'Listen-Notes' , label:  'Listen Notes'},
                                { value: 'Miro' , label:  'Miro'},
                                { value: 'MixCloud' , label:  'MixCloud'},
                                { value: 'myTuner-Radio' , label:  'MyTuner Radio'},
                                { value: 'Overcast' , label:  'Overcast'},
                                { value: 'OwlTail' , label:  'OwlTail'},
                                { value: 'Pandora' , label:  'Pandora'},
                                { value: 'Patreon' , label:  'Patreon'},
                                { value: 'Player.fm' , label:  'Player.fm'},
                                { value: 'Plex' , label:  'Plex'},
                                { value: 'PocketCasts' , label:  'PocketCasts'},
                                { value: 'Podbay' , label:  'Podbay'},
                                { value: 'Podbean' , label:  'Podbean'},
                                { value: 'Podcast.de' , label:  'Podcast.de'},
                                { value: 'Podcast-Addict' , label:  'Podcast Addict'},
                                { value: 'Podcast-Index' , label:  'Podcast Index'},
                                { value: 'Podcast-Republic' , label:  'Podcast Republic'},
                                { value: 'Podchaser' , label:  'Podchaser'},
                                { value: 'Podcoin' , label:  'Podcoin'},
                                { value: 'Podfan' , label:  'Podfan'},
                                { value: 'Podfriend' , label:  'Podfriend'},
                                { value: 'Podkicker' , label:  'Podkicker'},
                                { value: 'Podknife' , label:  'Podknife'},
                                { value: 'Podtail' , label:  'Podtail'},
                                { value: 'Radio-Public' , label:  'Radio Public'},
                                { value: 'Radio.com' , label:  'Radio.com'},
                                { value: 'RedCircle' , label:  'RedCircle'},
                                { value: 'RSS' , label:  'RSS'},
                                { value: 'RSSRadio' , label:  'RSSRadio'},
                                { value: 'SoundCloud' , label:  'SoundCloud'},
                                { value: 'Spotify' , label:  'Spotify'},
                                { value: 'Spreaker' , label:  'Spreaker'},
                                { value: 'Stitcher' , label:  'Stitcher'},
                                { value: 'Swoot' , label:  'Swoot'},
                                { value: 'The-Podcast-App' , label:  'The Podcast App'},
                                { value: 'TuneIn' , label:  'TuneIn'},
                                { value: 'VKontakte' , label:  'VKontakte'},
                                { value: 'Vurbl' , label:  'VURBL'},
                                { value: 'We.fo' , label:  'We.fo'},
                                { value: 'Yandex' , label:  'Yandex'},
                                { value: 'YouTube' , label:  'YouTube'},
                                { value: 'custom' , label:  'Custom Link'},
                            ] }
                            onChange={ handleServiceChange.bind(this,index) }
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__("Link",'secondline-psb-custom-buttons')}
                            value={ service.secondline_psb_subscribe_url }
                            onChange={ handleLinkChange.bind(this,index) }
                        />
                    </PanelRow>
                    <PanelRow>
                        <TextControl
                            label={__("Custom Link - Label",'secondline-psb-custom-buttons')}
                            value={ service.secondline_psb_custom_link_label }
                            onChange={ handleCustomLabelChange.bind(this,index) }
                        />
                    </PanelRow>
                    <PanelRow>
                        <Button variant="secondary" onClick={ handleDelete.bind(this,index) }>{__('Delete','secondline-psb-custom-buttons')}</Button>
                    </PanelRow>
                </CardBody>
            </Card>
        })}
        <PanelRow>
            <Button variant="primary" onClick={ handleAdd.bind(this) }>{__('Add Service','secondline-psb-custom-buttons')}</Button>
        </PanelRow>
    </>;
};
export default ServicesRepeater;
