<?php

namespace App\ApiDocs\V1;

/**
 * @OA\Tag(
 *   name="Контакты",
 *   description="Методы для работы с контактами"
 * ),
 * @OA\Tag(
 *   name="Авторизация",
 *   description="Получение токена"
 * ),
 * @OA\Info(
 *      version=API_VERSION,
 *      title="Телефонная книга",
 *      description="Доступные методы API",
 *      @OA\Contact(
 *          email="bezarama@yandex.ru"
 *      ),
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="PhoneBook API Server"
 * )
 *
 *
 */
class Controller
{

    /**
     * @OA\Post(
     *      tags={"Авторизация"},
     *      path="/token",
     *      summary="Получить токен, используя логин и пароль",
     *      @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Пароль",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Newly generated token in response body.",
     *          @OA\JsonContent(),
     *      ),
     * @OA\Tag(
     *     name="PhoneBook",
     *     description="API Endpoints for Contacts"
     * )
     * )
     */
    public function getToken()
    {

    }

}
