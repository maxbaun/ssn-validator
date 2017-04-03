import 'jquery';

import Router from './src/utils/router';
import common from './src/routes/common';

const routes = new Router({
	common
});

jQuery(document).ready(() => routes.loadEvents());
