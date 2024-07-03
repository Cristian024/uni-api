<?php
#MODELS
require_once __DIR__ . '/../app/models/response.php';
require_once __DIR__ . '/../app/models/user.php';
require_once __DIR__ . '/../app/models/student.php';
require_once __DIR__ . '/../app/models/session.php';
require_once __DIR__ . '/../app/models/careers.php';
require_once __DIR__ . '/../app/models/faculties.php';

#CONTROLLERS
require_once __DIR__ . '/../app/controllers/general/dataBaseController.php';
require_once __DIR__ . '/../app/controllers/general/responseController.php';
require_once __DIR__ . '/../app/controllers/general/serverController.php';
require_once __DIR__ . '/../app/controllers/users/userController.php';
require_once __DIR__ . '/../app/controllers/users/studentController.php';
require_once __DIR__ . '/../app/controllers/session/sessionController.php';
require_once __DIR__ . '/../app/controllers/faculties/careersController.php';
require_once __DIR__ . '/../app/controllers/faculties/facultiesController.php';

#CREDENTIALS
require_once __DIR__ . '/../config/credentials.php';

#DATABASE
require_once __DIR__ . '/../config/database.php';

#ROUTER
require_once __DIR__ . '/../routes/routes.php';
require_once __DIR__ . '/../app/services/router.php';

#HELPERS
require_once __DIR__ . '/../app/helpers/databaseHelper.php';
require_once __DIR__ . '/../app/helpers/requestHelper.php';