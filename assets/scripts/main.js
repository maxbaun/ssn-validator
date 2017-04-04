import 'jquery';

import Router from './src/utils/router';
import common from './src/routes/common';
import wpAdmin from './src/routes/wpAdmin';

const routes = new Router({
	common,
	wpAdmin
});

jQuery(document).ready(() => routes.loadEvents());
