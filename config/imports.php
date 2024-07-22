<?php
#MODELS
require_once __DIR__ . '/../app/models/filter.php';
require_once __DIR__ . '/../app/models/model.php';
require_once __DIR__ . '/../app/models/response.php';
require_once __DIR__ . '/../app/models/users.php';
require_once __DIR__ . '/../app/models/students.php';
require_once __DIR__ . '/../app/models/enterprises.php';
require_once __DIR__ . '/../app/models/sessions.php';
require_once __DIR__ . '/../app/models/careers.php';
require_once __DIR__ . '/../app/models/faculties.php';
require_once __DIR__ . '/../app/models/contacts.php';
require_once __DIR__ . '/../app/models/conversations.php';
require_once __DIR__ . '/../app/models/messages.php';

#CONTROLLERS
require_once __DIR__ . '/../app/controllers/general/dataBaseController.php';
require_once __DIR__ . '/../app/controllers/general/responseController.php';
require_once __DIR__ . '/../app/controllers/general/serverController.php';
require_once __DIR__ . '/../app/controllers/users/userController.php';
require_once __DIR__ . '/../app/controllers/users/enterpriseController.php';
require_once __DIR__ . '/../app/controllers/users/studentController.php';
require_once __DIR__ . '/../app/controllers/session/sessionController.php';
require_once __DIR__ . '/../app/controllers/faculties/careersController.php';
require_once __DIR__ . '/../app/controllers/faculties/facultiesController.php';
require_once __DIR__ . '/../app/controllers/users/contactsController.php';
require_once __DIR__ . '/../app/controllers/chat/conversationsController.php';
require_once __DIR__ . '/../app/controllers/chat/messagesController.php';

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