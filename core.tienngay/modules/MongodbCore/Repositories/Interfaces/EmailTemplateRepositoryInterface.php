<?php

namespace Modules\MongodbCore\Repositories\Interfaces;

interface EmailTemplateRepositoryInterface
{

    public function saveTemplate($data = []);

    public function updateTemplate($data = [], $id);

    public function getAll($data = []);
}
