<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mood extends Model
{
    //
    protected $table = 'moods';
    protected $fillable = [
        'mood_key',
        'sort_order',
        'feeling',
        'nuance',
        'song',
        'question',
        'choice_1',
        'choice_2',
        'choice_3',
        'choice_4',
        'answer',
        'coordinate',
        'why',
        'affirmation',
        'weather_text',
        'audio_path',
        'artwork_path',
        'color_primary',
        'color_secondary',
        'color_accent',
        'color_text',
        'mof_url',
    ];

    public function choices(): array
    {
        return [$this->choice_1, $this->choice_2, $this->choice_3, $this->choice_4];
    }

    public function barGradient(): string
    {
        return "linear-gradient(180deg,{$this->color_primary} 0%,{$this->color_secondary} 50%,{$this->color_accent} 100%)";
    }

    public function pageGradient(): string
    {
        return "radial-gradient(circle at 18% 22%,{$this->color_primary} 0%,{$this->color_secondary} 48%,{$this->color_accent} 100%)";
    }

    public function artworkUrl(): string
    {
        return $this->artwork_path ? asset($this->artwork_path) : '';
    }

    public function audioUrl(): string
    {
        return $this->audio_path ? asset($this->audio_path) : '';
    }

    public function submissions()
    {
        return $this->hasMany(mood_submissions::class);
    }

    /**
     * Bentuk data persis kayak yang dulu ditulis manual di window.MAP_OF_FEELINGS.
     * Dipanggil dari homeController lewat $moods->map->toJsPayload() lalu di-@json() ke blade.
     */
    public function toJsPayload(): array
    {
        return [
            'id' => $this->mood_key,
            'feeling' => $this->feeling,
            'nuance' => $this->nuance,
            'song' => $this->song,
            'question' => $this->question,
            'choices' => $this->choices(),
            'answer' => $this->answer,
            'coordinate' => $this->coordinate,
            'barGradient' => $this->barGradient(),
            'pageGradient' => $this->pageGradient(),
            'artwork' => $this->artworkUrl(),
            'audio' => $this->audioUrl(),
            'why' => $this->why,
            'affirmation' => $this->affirmation,
            'weatherText' => $this->weather_text,
            'colorText' => $this->color_text,
            'mof' => $this->mof_url ?: '#',
        ];
    }
}