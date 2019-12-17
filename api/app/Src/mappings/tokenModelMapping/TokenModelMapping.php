<?php

namespace App\Src\mappings\tokenModelMapping;

use App\GraphQLModel;
use App\Src\mappings\userModelMapping\UserModelMapping;
use App\Src\models\TokenModel\TokenModel;
use App\User;

class TokenModelMapping
{
    /**
     * @param TokenModel $model
     * @return GraphQLModel
     */
    public static function toGraphQLModelMapping(TokenModel $model)
    {
        $graphQLModel = new GraphQLModel();
        $graphQLModel->token = $model->getToken();
        $graphQLModel->token_type = $model->getTokenType();
        $graphQLModel->expires_in = $model->getExpiresIn();
        $graphQLModel->user = UserModelMapping::toUserDBMapping($model->getUser());
        return $graphQLModel;
    }
}