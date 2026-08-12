<?php

namespace App\Utils;

use Illuminate\Http\Request;

class DTO
{
    private array $data = [];

    private array $files = [];

    public function __construct(array $data, array $files = [])
    {
        $this->data = $data;
        $this->files = $files;
    }

    public function getData(): array
    {
        $data = $this->data;

        unset($data['user']);

        return $data;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? $this->files[$key] ?? null;
    }

    public static function FromRequest(Request $request, array $fields, $user = null)
    {
        $data = [];
        $files = [];

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $files[$field] = $request->file($field);
            } else {
                $data[$field] = $request->input($field);
            }
        }

        if ($user) {
            $data['user'] = $user;
        }

        $object = new self($data, $files);

        return $object;
    }

    public function append(array $additionalData)
    {
        $this->data = array_merge($this->data, $additionalData);
    }
}