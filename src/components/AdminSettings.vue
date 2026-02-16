<template>
	<div id="sendrec-admin-settings">
		<h2>SendRec</h2>
		<p class="settings-hint">
			{{ t('integration_sendrec', 'Configure your SendRec instance to enable link previews and video search.') }}
		</p>
		<div class="field">
			<label for="sendrec-instance-url">
				{{ t('integration_sendrec', 'SendRec instance URL') }}
			</label>
			<input
				id="sendrec-instance-url"
				v-model="instanceUrl"
				type="url"
				:placeholder="t('integration_sendrec', 'https://videos.example.com')"
				@input="onSave">
		</div>
		<div class="field">
			<label for="sendrec-api-key">
				{{ t('integration_sendrec', 'API key') }}
			</label>
			<input
				id="sendrec-api-key"
				v-model="apiKey"
				type="password"
				:placeholder="t('integration_sendrec', 'sr_…')"
				@input="onSave">
			<p class="settings-hint">
				{{ t('integration_sendrec', 'Generate an API key in your SendRec instance under Settings > API Keys.') }}
			</p>
		</div>
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import { showError, showSuccess } from '@nextcloud/dialogs'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'AdminSettings',
	props: {
		initialState: {
			type: Object,
			default: () => ({}),
		},
	},

	data() {
		return {
			instanceUrl: this.initialState.instance_url || '',
			apiKey: this.initialState.api_key || '',
			saveTimeout: null,
		}
	},

	methods: {
		onSave() {
			clearTimeout(this.saveTimeout)
			this.saveTimeout = setTimeout(this.save, 500)
		},

		async save() {
			try {
				await axios.put(generateUrl('/apps/integration_sendrec/admin-config'), {
					instanceUrl: this.instanceUrl,
					apiKey: this.apiKey,
				})
				showSuccess(this.t('integration_sendrec', 'SendRec settings saved'))
			} catch {
				showError(this.t('integration_sendrec', 'Failed to save SendRec settings'))
			}
		},
	},
}
</script>

<style scoped>
.field {
	margin: 16px 0;
}

.field label {
	display: block;
	font-weight: 600;
	margin-bottom: 4px;
}

.field input {
	width: 100%;
	max-width: 400px;
}

.settings-hint {
	color: var(--color-text-maxcontrast);
	font-size: 13px;
	margin-top: 4px;
}
</style>
