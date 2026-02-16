import path from 'path'
import webpackConfig from '@nextcloud/webpack-vue-config'

const appId = 'integration_sendrec'

webpackConfig.entry = {
	reference: {
		import: path.join(import.meta.dirname, 'src', 'reference.js'),
		filename: appId + '-reference.js',
	},
	adminSettings: {
		import: path.join(import.meta.dirname, 'src', 'adminSettings.js'),
		filename: appId + '-adminSettings.js',
	},
	personalSettings: {
		import: path.join(import.meta.dirname, 'src', 'personalSettings.js'),
		filename: appId + '-personalSettings.js',
	},
}

export default webpackConfig
