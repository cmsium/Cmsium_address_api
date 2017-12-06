<?php
define ("USER_PARAM_ABSENT",['code' => 100, 'text' => 'Server side error']);
define ("UNDEFINED_METHOD",['code' => 101, 'text' => 'Неопознанный метод!',"page" => 'undef_method']);
define ("CALLBACK_ERROR",['code' => 102, 'text' => 'Server side error']);
define ("DELETE_CONFIRM",['code' => 103, 'text' => 'Пользователь успешно удален!']);
define ("EXECUTE_ERROR",['code' => 104, 'text' => 'Server side error']);
define ("DATA_FORMAT_ERROR",['code' => 105, 'text' => 'Неверный формат данных','page'=>'data_format_error']);
define ("UPDATE_SUCCESS",['code' => 106, 'text' => 'Информация пользователя успешно отредактирована']);
define ("UPDATE_ERROR",['code' => 107, 'text' => 'Ошибка редактирования','page'=>'error']);
define ("NO_DATA",['code' => 108, 'text' => 'Нет данных для обновления']);
define ("AUTH_CONFIRM",['code' => 109, 'text' => 'Пользователь авторизирован', 'page' => 'auth_confirm']);
define ("AUTH_ERROR",['code' => 110, 'text' => 'Ошибка авторизации']);
define ("POST_DATA_ABSENT",['code' => 111, 'text' => 'Введите данные в форму']);
define ("LOGOUT_SUCCESS",['code' => 112, 'text' => 'Вы успешно вышли из системы!']);
define ("PASSWORD_CHECK_ERROR",['code' => 113, 'text' => 'Пароли не совпадают']);
define ("CREATE_SUCCESS",['code' => 114, 'text' => 'Пользователь успещно добавлен!']);
define ("CREATE_ERROR",['code' => 115, 'text' => 'Не удалось добавить пользователя!']);
define ("PARAM_ERROR",['code' => 116, 'text' => 'Server side error']);
define ("SELF_DELETE",['code' => 117, 'text' => 'Попытка удалить собственный аккаунт!']);
define ("NO_FILE_FOUND",['code' => 118, 'text' => 'Файл не найден!']);
define ("ERROR_DB_CONNECTION",['code' => 119, 'text' => 'Не удалось подключиться к базе данных!']);
define ("PERFORM_QUERY_ERROR",['code' => 120, 'text' => 'Не удалось выполнить запрос к базе данных!']);
define ("UNDEFINED_CUSTOM_NAME",['code' => 121, 'text' => 'Server side error']);
define ("PASSWORD_UPDATE_FAIL",['code' => 122, 'text' => 'Не удалось обновить пароль!']);
define ("PASSWORD_UPDATE_SUCCESS",['code' => 123, 'text' => 'Пароль успешно обновлен!']);
define ("ERROR_DB_TRANSACTION",['code' => 124, 'text' => 'Server side error']);
define ("NOT_FOUND",['code' => 404, 'text' => '404 Not Found !', 'page'=>'404']);
define ("CUSTOM_CLASS_ERROR",['code' => 124, 'text' => 'Custom class error!', 'page'=>'custom_class_error']);
define ("WRONG_MODULE",['code' => 125, 'text' => 'Custom module have not exist!', 'page'=>'custom_module_error']);
define ("SESSION_TIMED_OUT",['code' => 126, 'text' => 'Время сессии истекло!', 'page'=>'custom_module_error']);
define ("CREATE_VALIDATION_ERROR",['code' => 127, 'text' => 'Неверный формат данных', 'page'=>'create_validation_error']);
define ("AUTH_VALIDATION_ERROR",['code' => 128, 'text' => 'Неверный формат данных', 'page'=>'auth_validation_error']);
define ("DB_CONN_CLOSE_ERROR",['code' => 129, 'text' => 'Server side error']);
define ("UPDATE_VALIDATION_ERROR",['code' => 130, 'text' => 'Неверный формат данных', 'page'=>'update_validation_error']);
define ("COOKIE_SET_ERROR",['code' => 131, 'text' => 'Server side error']);
define ("COOKIE_GET_ERROR",['code' => 132, 'text' => 'Server side error', 'page' => 'cookie_error']);
define ("FILE_PARAM_ABSENT",['code' => 133, 'text' => 'Параметр файла не передан!', "page" => 'no_file_param']);
define ("DIRECT_UPLOAD",['code' => 134, 'text' => 'Не удалось загрузить файл', "page" => 'error']);
define ("FILE_SIZE_ERROR",['code' => 135, 'text' => 'Размер файла слишком велик!', "page" => 'error']);
define ("FILE_UPLOAD_ERROR",['code' => 136, 'text' => 'Не удалось загрузить файл', "page" => 'error']);
define ("FILE_UPLOAD_SUCCESS",['code' => 137, 'text' => 'Файл успешно загружен', "page" => 'error']);
define ("NO_FILE_UPLOAD",['code' => 138, 'text' => 'Не удалось загрузить файл', "page" => 'error']);
define ("FILE_DELTE_BASE_ERROR",['code' => 139, 'text' => 'Не удалось удалить файл', "page" => 'error']);
define ("FILE_DELTE_ERROR",['code' => 140, 'text' => 'Не удалось удалить файл', "page" => 'error']);
define ("FILE_DELTE_SUCCESS",['code' => 141, 'text' => 'Файл успешно удален', "page" => 'error']);
define ("FILE_NOT_IMAGE_ERROR",['code' => 142, 'text' => 'Файл не является изображением', "page" => 'error']);
define ("UNDEFINED_FILE",['code' => 143, 'text' => 'Файл не найден', "page" => 'error']);
define ("ZIP_OPEN_ERROR",['code' => 144, 'text' => 'Server side error', "page" => 'error']);
define ("PERMISSIONS_ERROR",['code' => 145, 'text' => 'Нeдостаточно прав!', "page" => 'error']);
define ("NOT_ALLOWED_EVENT_TYPE",['code' => 146, 'text' => 'Не верный тип ивента', "page" => 'error']);
define ("UNSUPPORTED_DATA_TYPE",['code' => 147, 'text' => 'Неподдерживаемый тип данных', "page" => 'error']);
define ("UNDEFINED_EVENT",['code' => 148, 'text' => 'Евент не найден', "page" => 'error']);
define ("GET_DATA_ABSENT",['code' => 149, 'text' => 'Введите данные в форму', "page" => 'error']);
define ("CANNOT_WRITE_FILE",['code' => 150, 'text' => 'Невозможно записать файл', "page" => 'error']);
define ("CREATE_EVENT_TYPE_SUCCESS",['code' => 151, 'text' => 'Тип события успешно создан']);
define ("DELETE_EVENT_TYPE_SUCCESS",['code' => 152, 'text' => 'Тип события успешно удален']);
define ("EVENT_CREATE_SUCCESS",['code' => 153, 'text' => 'Событие успешно добавлено']);
define ("EVENT_UPDATE_SUCCESS",['code' => 154, 'text' => 'Событие успешно обновлено']);
define ("ARRAY_TO_XML_CONVERT_ERROR",['code' => 155, 'text' => 'Server side error']);
define ("BASE_ERROR",['code' => 156, 'text' => 'Что-то пошло не так', "page" => 'error']);
define ("PORT_VALIDATION_ERROR",['code' => 157, 'text' => 'Неверный формат данных', 'page'=>'validation_error']);
define ("PORT_SELECT_VALIDATION_ERROR",['code' => 158, 'text' => 'Неверный формат данных', 'page'=>'select_validation_error']);
define ("ARRAY_KEY_NOT_FOUND",['code' => 159, 'text' => 'Server side error', 'page'=>'error']);
define ("EVENT_DELETE_CONFIRM",['code' => 160, 'text' => 'Событие успешно удалено!']);
define ("ADDRESS_WRITE_ERROR",['code' => 161, 'text' => 'Server side error', 'page'=>'error']);
define ("ADDRESS_DESTROY_ERROR",['code' => 162, 'text' => 'Server side error!', 'page'=>'error']);
define ("NO_TYPES_FOUND",['code' => 163, 'text' => 'События не найдены!', 'page'=>'error']);
define ("LOG_ERROR",['code' => 164, 'text' => 'Server side error', 'page'=>'error']);
define ("DELETE_ERROR",['code' => 165, 'text' => 'Не удалось удалить пользователя']);
define ("CREATE_ROLE_SUCCESS",['code' => 166, 'text' => 'Роль успешно создана']);
define ("CREATE_ROLE_VALIDATION_ERROR",['code' => 167, 'text' => 'Неверный формат данных', 'page'=>'create_role_validation_error']);
define ("DELETE_ROLE_SUCCESS",['code' => 168, 'text' => 'Роль успешно удалена']);
define ("DELETE_ROLE_ERROR",['code' => 169, 'text' => 'Не удалось удалить роль']);
define ("CREATE_COUNTRY_TABLE_ERROR",['code' => 170, 'text' => 'Server side error', 'page'=>'error']);
define ("COUNTRY_NOT_FOUND",['code' => 171, 'text' => 'Server side error', 'page'=>'error']);
define ("ADDRESS_INPUT_ERROR",['code' => 172, 'text' => 'Неверно указан адрес!']);
define ("SELF_UPDATE_VALIDATION_ERROR",['code' => 173, 'text' => 'Неверный формат данных', 'page'=>'self_update_validation_error']);
define ("SELF_PROPS_UPDATE_VALIDATION_ERROR",['code' => 174, 'text' => 'Неверный формат данных', 'page'=>'self_props_update_validation_error']);
define ("PASSWORD_VALIDATION_ERROR",['code' => 175, 'text' => 'Неверный формат данных', 'page'=>'password_update_validation_error']);
define ("UPDATE_PROPS_VALIDATION_ERROR",['code' => 176, 'text' => 'Неверный формат данных', 'page'=>'props_update_validation_error']);
define ("CREATE_ROLE_ERROR",['code' => 177, 'text' => 'Невозможно создать роль','page'=>'create_role_error']);
define ("CREATE_EVENT_TYPE_ERROR",['code' => 178, 'text' => 'Невозможно создать тип события','page'=>'create_event_type_error']);
define ("PORT_CREATE_TYPE_VALIDATION_ERROR",['code' => 179, 'text' => 'Неверный формат данных','page'=>'validation_event_type_error']);
define ("DATE_MIN_MAX_ERROR",['code' => 180, 'text' => 'Неверно указаны даты!']);
define ("CREATE_DOC_TYPE_SUCCESS",['code' => 181, 'text' => 'Тип документа успешно создан']);
define ("DELETE_DOC_TYPE_SUCCESS",['code' => 182, 'text' => 'Тип документа успешно удален']);
define ("NOT_ALLOWED_DOC_TYPE",['code' => 183, 'text' => 'Неверный тип документа', "page" => 'error']);
define ("UNDEFINED_DOCUMENT",['code' => 184, 'text' => 'Документ не найден', "page" => 'error']);
define ("CREATE_DOCUMENT_TYPE_ERROR",['code' => 185, 'text' => 'Невозможно создать тип документа','page'=>'create_doc_type_error']);
define ("DOCUMENT_UPDATE_SUCCESS",['code' => 186, 'text' => 'Документ успешно обновлен']);
define ("DOCUMENT_CREATE_SUCCESS",['code' => 187, 'text' => 'Документ успешно добавлен!']);
define ("DOCUMENT_DELETE_CONFIRM",['code' => 188, 'text' => 'Документ успешно удален!']);
define ("DOCUMENT_VALIDATION_ERROR",['code' => 189, 'text' => 'Неверный формат данных', 'page'=>'document_validation_error']);
define ("UPDATE_EVENT_TYPE_ERROR",['code' => 190, 'text' => 'Невозможно обновить тип события','page'=>'update_event_type_error']);
define ("PORT_UPDATE_TYPE_VALIDATION_ERROR",['code' => 191, 'text' => 'Неверный формат данных','page'=>'validation_event_type_error']);
define ("UPDATE_EVENT_TYPE_SUCCESS",['code' => 192, 'text' => 'Тип события успешно обновлен']);
define ("USERS_FILTER_VALIDATION_ERROR",['code' => 193, 'text' => 'Неверный формат данных','page'=>'users_validation_error']);
define ("DESTROY_DOCUMENT_TYPE_ERROR",['code' => 194, 'text' => 'Невозможно удалить тип документа']);
define ("CREATE_DIFF_ERROR",['code' => 195, 'text' => 'Server side error']);
define ("READ_DIFF_ERROR",['code' => 196, 'text' => 'Server side error']);
define ("INVALID_ACTION",['code' => 197, 'text' => 'Недопустимое действие!']);
define ("CODE_NOT_FOUND",['code' => 198, 'text' => 'Указанный код не найден!']);
define ("CODE_NOT_FRESH",['code' => 199, 'text' => 'Указанный код истек и был отправлен заново!']);
define ("CODE_REDEEMED",['code' => 200, 'text' => 'Почта успешно подтверждена!']);
define ("USER_ACTIVATION_FAILED",['code' => 201, 'text' => 'Ошибка активации пользователя!']);