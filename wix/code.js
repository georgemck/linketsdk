import {getJSON} from 'wix-fetch';
import wixLocation from 'wix-location';

$w.onReady(function () {
	$w("#button5").onClick( (event, $w) => {
		getJSON("https://e18inyvxpe.execute-api.us-east-1.amazonaws.com/linket_backend?command=getLinket&linket=[%20Flowers%20]")
			.then(json => wixLocation.to(json[0].value.appid))
			.catch(err => console.log(err));
	} );
});

/**
 * 
 * INSTRUCTION STEPS on
 * https://linket.info/wix-sdk/
 * 
 * 1. Create Wix account
 * 2. Turn on Developer Mode
 * 3. Add Button. Change button label to your Linket
 * 4. Copy paste code above
 * 5. Update Flowers to your Linket
 * 6. Update button5 to the ID of the new button created in Wix
 * 7. Save, Publish, Open Site
 */