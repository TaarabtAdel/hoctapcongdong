<?php

namespace App\Support\Concerns;

trait HasSeo
{
    public function seoTitle(): string
    {
        return $this->seo_title ?: $this->title;
    }

    public function seoDescription(): ?string
    {
        return $this->seo_description ?: $this->excerpt;
    }
}
