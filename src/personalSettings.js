import { getCSPNonce } from '@nextcloud/auth'
import { loadState } from '@nextcloud/initial-state'
import { n, t } from '@nextcloud/l10n'
import { linkTo } from '@nextcloud/router'
import { createApp } from 'vue'
import PersonalSettings from './components/PersonalSettings.vue'

__webpack_nonce__ = getCSPNonce()
__webpack_public_path__ = linkTo('integration_sendrec', 'js/')

const state = loadState('integration_sendrec', 'personal-config', {})

const el = document.getElementById('sendrec-personal-settings')
if (el) {
	const app = createApp(PersonalSettings, { initialState: state })
	app.mixin({ methods: { t, n } })
	app.mount(el)
}
