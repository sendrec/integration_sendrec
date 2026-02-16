<template>
	<div id="sendrec-personal-settings">
		<h2>SendRec</h2>
		<div class="field">
			<input
				id="sendrec-search-enabled"
				v-model="searchEnabled"
				type="checkbox"
				@change="onSave">
			<label for="sendrec-search-enabled">
				{{ t('integration_sendrec', 'Enable unified search for SendRec videos') }}
			</label>
		</div>
		<div class="field">
			<input
				id="sendrec-link-preview-enabled"
				v-model="linkPreviewEnabled"
				type="checkbox"
				@change="onSave">
			<label for="sendrec-link-preview-enabled">
				{{ t('integration_sendrec', 'Enable link previews for SendRec watch URLs') }}
			</label>
		</div>
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import { showError, showSuccess } from '@nextcloud/dialogs'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'PersonalSettings',
	props: {
		initialState: {
			type: Object,
			default: () => ({}),
		},
	},

	data() {
		return {
			searchEnabled: this.initialState.search_enabled !== false,
			linkPreviewEnabled: this.initialState.link_preview_enabled !== false,
		}
	},

	methods: {
		async onSave() {
			try {
				await axios.put(generateUrl('/apps/integration_sendrec/personal-config'), {
					searchEnabled: this.searchEnabled,
					linkPreviewEnabled: this.linkPreviewEnabled,
				})
				showSuccess(this.t('integration_sendrec', 'SendRec preferences saved'))
			} catch {
				showError(this.t('integration_sendrec', 'Failed to save SendRec preferences'))
			}
		},
	},
}
</script>

<style scoped>
.field {
	margin: 12px 0;
	display: flex;
	align-items: center;
	gap: 8px;
}
</style>
