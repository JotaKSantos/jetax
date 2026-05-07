<?php

namespace Jetax\DesignSystem\DataTable\Columns;

class TextColumn extends Column
{
    public function render(mixed $row): mixed
    {
        return data_get($row, $this->key) ?? '';
    }
}
