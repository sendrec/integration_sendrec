import { getCSPNonce } from '@nextcloud/auth'
import { loadState } from '@nextcloud/initial-state'
import { n, t } from '@nextcloud/l10n'
import { linkTo } from '@nextcloud/router'
import { createApp } from 'vue'
import AdminSettings from './components/AdminSettings.vue'

__webpack_nonce__ = getCSPNonce()
__webpack_public_path__ = linkTo('integration_sendrec', 'js/')

const state = loadState('integration_sendrec', 'admin-config', {})

const el = document.getElementById('sendrec-admin-settings')
if (el) {
	const app = createApp(AdminSettings, { initialState: state })
	app.mixin({ methods: { t, n } })
	app.mount(el)
}
