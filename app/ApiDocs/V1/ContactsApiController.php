<?php

namespace App\ApiDocs\V1;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactsApiController extends Controller
{

    /**
     * @OA\Get(
     *      path="/contacts",
     *      tags={"Контакты"},
     *      summary="Получить список контактов",
     *      description="",
     *      security={ {"sanctum": {} }},
     *      @OA\Response( response=200, description="Successful operation", @OA\JsonContent() ),
     *      @OA\Response( response=400, description="Bad Request", @OA\JsonContent() ),
     *      @OA\Response( response=401, description="Unauthenticated", @OA\JsonContent() ),
     *      @OA\Response( response=403, description="Forbidden", @OA\JsonContent() )
     * )
     */
    public function index()
    {
    }


    /**
     * @OA\Post(
     *      path="/contacts",
     *      tags={"Контакты"},
     *      summary="Добавить контакт",
     *      description="",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"first_name","phone"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="middle_name", type="string", example="Bon"),
     *              @OA\Property(property="last_name", type="string", example="Jovie"),
     *              @OA\Property(property="phone", type="string", example="12345678901"),
     *              @OA\Property(property="is_favourite", type="boolean", example="true"),
     *          ),
     *      ),
     *      @OA\Response( response=201, description="Resource created", @OA\JsonContent() ),
     *      @OA\Response( response=400, description="Bad Request", @OA\JsonContent() ),
     *      @OA\Response( response=401, description="Unauthenticated", @OA\JsonContent() ),
     *      @OA\Response( response=403, description="Forbidden", @OA\JsonContent() ),
     * )
     */
    public function store(StoreContactRequest $request)
    {
    }

    /**
     * @OA\Get(
     *      path="/contacts/{id}",
     *      tags={"Контакты"},
     *      summary="Получить детали контакта по его id",
     *      description="",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Contact id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response( response=200, description="Successful operation", @OA\JsonContent() ),
     *      @OA\Response( response=400, description="Bad Request", @OA\JsonContent() ),
     *      @OA\Response( response=401, description="Unauthenticated", @OA\JsonContent() ),
     *      @OA\Response( response=403, description="Forbidden", @OA\JsonContent() ),
     *      @OA\Response( response=404, description="Not found", @OA\JsonContent() ),
     * )
     */
    public function show()
    {
    }

    /**
     * @OA\Patch  (
     *      path="/contacts/{id}",
     *      tags={"Контакты"},
     *      summary="Редактировать контакт",
     *      description="",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Contact id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"first_name","phone"},
     *              @OA\Property(property="first_name", type="string", example="Marry"),
     *              @OA\Property(property="middle_name", type="string", example="F-king"),
     *              @OA\Property(property="last_name", type="string", example="Poppins"),
     *              @OA\Property(property="phone", type="string", example="12345678901"),
     *              @OA\Property(property="is_favourite", type="boolean", example="true"),
     *          ),
     *      ),
     *      @OA\Response( response=200, description="Resource updated", @OA\JsonContent() ),
     *      @OA\Response( response=400, description="Bad Request", @OA\JsonContent() ),
     *      @OA\Response( response=401, description="Unauthenticated", @OA\JsonContent() ),
     *      @OA\Response( response=403, description="Forbidden", @OA\JsonContent() ),
     *      @OA\Response( response=404, description="Not found", @OA\JsonContent() ),
     * )
     */
    public function update(UpdateContactRequest $request, int $id)
    {
    }

    /**
     * @OA\Delete  (
     *      path="/contacts/{id}",
     *      tags={"Контакты"},
     *      summary="Удалить контакт",
     *      description="",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Contact id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response( response=200, description="Resource deleted", @OA\JsonContent() ),
     *      @OA\Response( response=400, description="Bad Request", @OA\JsonContent() ),
     *      @OA\Response( response=401, description="Unauthenticated", @OA\JsonContent() ),
     *      @OA\Response( response=403, description="Forbidden", @OA\JsonContent() ),
     *      @OA\Response( response=404, description="Not found", @OA\JsonContent() ),
     * )
     */
    public function destroy()
    {
    }
}
