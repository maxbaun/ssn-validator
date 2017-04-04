import 'jquery';
import 'jquery-ui-bundle';
// import 'jquery-ui-bundle/jquery-ui.css';

import Router from './src/utils/router';
import common from './src/routes/common';
import wpAdmin from './src/routes/wpAdmin';

const routes = new Router({
	common,
	wpAdmin
});

jQuery(document).ready(() => routes.loadEvents());
