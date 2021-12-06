import { SelectControl } from '@wordpress/components';
const { useSelect } = wp.data;
import { __ } from '@wordpress/i18n';


const PostSelector = ({selected, setSelectedPost}) => {
    const { somePosts } = useSelect( ( select ) => {
        return {
            somePosts: select( 'core' ).getEntityRecords( 'postType', 'secondline_psb_post' ),
        };
    } );
    if( typeof selected === 'undefined' && somePosts ){
        setSelectedPost( parseInt( somePosts[0].id ) );
    }
    return (
        (somePosts && <SelectControl
            label={__("Podcast Button",'secondline-psb-custom-buttons')}
            value={ selected }
            options={
                somePosts.map(item => {return { label: item.title.rendered, value: item.id}})
            }
            onChange={ ( newValue ) => setSelectedPost( parseInt(newValue) ) }
        />)
    );
};
export default PostSelector;