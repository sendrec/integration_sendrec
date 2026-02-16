import { recommended } from '@nextcloud/eslint-config'

export default [
	...recommended,
	{
		languageOptions: {
			globals: {
				__webpack_nonce__: 'writable',
				__webpack_public_path__: 'writable',
			},
		},
	},
]
