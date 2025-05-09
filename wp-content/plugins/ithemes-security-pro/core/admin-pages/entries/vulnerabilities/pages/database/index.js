/**
 * External dependencies
 */
import { Link } from 'react-router-dom';
import { isEmpty } from 'lodash';

/**
 * WordPress dependencies
 */
import { useDispatch, useSelect } from '@wordpress/data';
import { __, sprintf } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import {
	chevronLeftSmall,
	chevronRightSmall,
	settings as filterIcon,
	warning,
} from '@wordpress/icons';
import { Dropdown } from '@wordpress/components';

/**
 * SolidWP dependencies
 */
import { Button, Heading, Text, TextSize, TextVariant, SurfaceVariant, FiltersGroupDropdown, Surface } from '@ithemes/ui';

/**
 * Internal dependencies
 */
import { patchstackStore } from '@ithemes/security.packages.data';
import { Patchstack } from '@ithemes/security-style-guide';
import { withNavigate } from '@ithemes/security-hocs';
import PatchstackTable from './table';
import { BeforeHeaderSlot } from '../../components/before-header/index';
import {
	StyledPageContainer, StyledPageHeader,
} from '../../components/styles';
import {
	StyledButtonsContainer,
	StyledFilters,
	StyledFilterTools,
	StyledPagination,
} from '../active/styles';
import {
	StyledDatabaseWarning,
} from './styles';
import { StyledBrand, StyledHeader } from '../../components/vulnerable-software-header/styles';
import '../../style.scss';

function DatabaseHeader() {
	return (
		<StyledHeader>
			<div>
				<Heading
					level={ 2 }
					size={ TextSize.LARGE }
					variant={ TextVariant.DARK }
					weight={ 600 }
					text={ __( 'Vulnerability Database', 'it-l10n-ithemes-security-pro' ) }
				/>
				<Text
					variant={ TextVariant.MUTED }
					text={ __( 'You are viewing the last two weeks of vulnerabilities from the database.', 'it-l10n-ithemes-security-pro' ) }
				/>
			</div>
			<StyledBrand>
				<Text text={ __( 'Powered by', 'it-l10n-ithemes-security-pro' ) } />
				<Patchstack />
			</StyledBrand>
		</StyledHeader>
	);
}

export default function Database() {
	const initialFilter = {};
	const [ filters, setFilters ] = useState( initialFilter );
	const { query, fetchQueryNextPage, fetchQueryPrevPage } = useDispatch( patchstackStore );
	const { items, isQuerying, queryHasNextPage, queryHasPrevPage } = useSelect( ( select ) => ( {
		items: select( patchstackStore ).getPatchstackVulnerabilities(),
		isQuerying: select( patchstackStore ).isQuerying( 'main' ),
		hasResolved: select( patchstackStore ).hasFinishedResolution( 'getPatchstackVulnerabilities' ),
		queryHasNextPage: select( patchstackStore ).queryHasNextPage( 'main' ),
		queryHasPrevPage: select( patchstackStore ).queryHasPrevPage( 'main' ),
	} ), [] );
	const getPrev = () => {
		fetchQueryPrevPage( 'main', 'replace' );
	};

	const getNext = () => {
		fetchQueryNextPage( 'main', 'replace' );
	};

	const onReset = ( ) => {
		setFilters( initialFilter );
		query( 'main', initialFilter );
		onApply( initialFilter );
	};

	const onApply = ( nextFilters ) => {
		setFilters( nextFilters );
		query( 'main', nextFilters );
	};

	return (
		<>
			<StyledDatabaseWarning
				variant={ SurfaceVariant.DARK }
			>
				<Text
					icon={ warning }
					text={ __( 'You are browsing the vulnerability database. These vulnerabilities do not affect your site. To see active vulnerabilities on your site, stop browsing the database.', 'it-l10n-ithemes-security-pro' ) }
					align="center"
				/>
			</StyledDatabaseWarning>
			<StyledPageContainer>
				<BeforeHeaderSlot />
				<StyledPageHeader>
					<StyledFilterTools>
						<Dropdown
							popoverProps={ { focusOnMount: 'container' } }
							renderToggle={ ( { isOpen, onToggle } ) => (
								<Button
									icon={ filterIcon }
									onClick={ onToggle }
									aria-expanded={ isOpen }
									variant="tertiary"
									text={ sprintf(
									/* translators: 1. Number of filters. */
										__( 'Filter (%d)', 'it-l10n-ithemes-security-pro' ),
										Object.keys( filters ).filter( ( key ) => ! isEmpty( filters[ key ] ) ).length
									) }
								/>
							) }
							renderContent={ () => (
								<StyledFilters
									initialValue={ filters }
									initialOpen={ [ 'type' ] }
									expandSingle
									isBusy={ isQuerying }
									onApply={ onApply }
								>
									<FiltersGroupDropdown
										slug="type"
										title={ __( 'Types', 'it-l10n-ithemes-security-pro' ) }
										options={ [
											{ value: 'themes', label: __( 'Themes', 'it-l10n-ithemes-security-pro' ) },
											{ value: 'plugins', label: __( 'Plugins', 'it-l10n-ithemes-security-pro' ) },
											{ value: 'wordpress', label: __( 'Core', 'it-l10n-ithemes-security-pro' ) },
										] }
									/>
								</StyledFilters>
							) }
						/>
						<Text variant={ TextVariant.MUTED }>&#124;</Text>
						<Button
							onClick={ onReset }
							variant="tertiary"
							text={ __( 'Reset all', 'it-l10n-ithemes-security-pro' ) }
						/>
					</StyledFilterTools>
					<StyledButtonsContainer>
						<Link to="/active" component={ withNavigate( Button ) } text={ __( 'Stop Browsing Database', 'it-l10n-ithemes-security-pro' ) } />
						<Link to="/scan" replace component={ withNavigate( Button ) } variant="primary" text={ __( 'Scan for Vulnerabilities', 'it-l10n-ithemes-security-pro' ) } />
					</StyledButtonsContainer>
				</StyledPageHeader>
				<Surface as="section">
					<DatabaseHeader />
					<PatchstackTable items={ items } />
				</Surface>
				<StyledPagination>
					<Button
						disabled={ ! queryHasPrevPage }
						icon={ chevronLeftSmall }
						variant="tertiary"
						onClick={ getPrev }
						text={ __( 'Prev', 'it-l10n-ithemes-security-pro' ) }
					/>
					<Button
						disabled={ ! queryHasNextPage }
						icon={ chevronRightSmall }
						iconPosition="right"
						variant="tertiary"
						onClick={ getNext }
						text={ __( 'Next', 'it-l10n-ithemes-security-pro' ) }
					/>
				</StyledPagination>
			</StyledPageContainer>
		</>
	);
}
