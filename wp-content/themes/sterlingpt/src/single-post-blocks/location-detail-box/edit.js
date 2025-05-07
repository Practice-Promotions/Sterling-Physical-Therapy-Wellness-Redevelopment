import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			<div className="location-back-contact">
				<div className="location-back-contact-info">
					<h2>Custom Title</h2>
					<h4>Contact Info</h4>
					<p className="icon-pin"> Keas 69 Str. 15234, Chalandri Athens, Greece </p>
					<div className="location-back-contact-wrap">
						<p className="icon-phone"> 000-000-0000 </p>
						<p className="icon-fax"> 000-000-0000 </p>
					</div>
					<p className="icon-envelop"> email@domain.com</p>
					<h4 className="mt-30">Business Hours</h4>
					<p className="location-back-hours icon-timer"> Mon-Fri: 8:00AM – 5:00PM Sat-Sun: By Appointment</p>
					<h4 className="mt-30">Directions/Located Near</h4>
					<p className="icon-flag"> Dummy address for testing purpose data lorem	</p>
				</div>
				<div className="location-back-contact-map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55565170.29301636!2d-132.08532758867793!3d31.786060306224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1643094494237!5m2!1sen!2sin" title="locations"></iframe>
				</div>
			</div>
		</div>
	);
}
