import { getCSPNonce } from '@nextcloud/auth'
import { linkTo } from '@nextcloud/router'
import { registerWidget } from '@nextcloud/vue/components/NcRichText'

__webpack_nonce__ = getCSPNonce()
__webpack_public_path__ = linkTo('integration_sendrec', 'js/')

registerWidget('integration_sendrec_video', async (el, { richObject, accessible }) => {
	const { createApp } = await import('vue')
	const { default: SendRecReferenceWidget } = await import('./components/SendRecReferenceWidget.vue')
	const { t, n } = await import('@nextcloud/l10n')
	const app = createApp(SendRecReferenceWidget, { richObject, accessible })
	app.mixin({ methods: { t, n } })
	app.mount(el)
})
