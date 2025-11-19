<?php

namespace App\Helpers;

use App\Models\ProfilDesa;
use Illuminate\Support\Facades\URL;

class SEOHelper
{
    /**
     * Generate meta tags for a page
     * 
     * @param array $data
     * @return array
     */
    public static function generateMetaTags(array $data = []): array
    {
        $profil = ProfilDesa::getInstance();
        
        $defaults = [
            'title' => $profil->nama_desa ?? 'Desa Warurejo',
            'description' => "Website resmi {$profil->nama_desa}, {$profil->kecamatan}, {$profil->kabupaten}, {$profil->provinsi}. Informasi berita, potensi desa, galeri, dan profil desa.",
            'keywords' => "desa warurejo, {$profil->kecamatan}, {$profil->kabupaten}, profil desa, berita desa, potensi desa",
            'image' => $profil->logo ? asset('storage/' . $profil->logo) : asset('images/logo.png'),
            'url' => URL::current(),
            'type' => 'website',
            'locale' => 'id_ID',
            'site_name' => $profil->nama_desa ?? 'Desa Warurejo',
            'twitter_card' => 'summary_large_image',
            'author' => $profil->nama_desa ?? 'Desa Warurejo',
        ];
        
        return array_merge($defaults, $data);
    }
    
    /**
     * Generate structured data (JSON-LD) for Organization
     * 
     * @return array
     */
    public static function getOrganizationSchema(): array
    {
        $profil = ProfilDesa::getInstance();
        
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "GovernmentOrganization",
            "name" => $profil->nama_desa ?? "Desa Warurejo",
            "url" => url('/'),
            "logo" => $profil->logo ? asset('storage/' . $profil->logo) : asset('images/logo.png'),
            "description" => $profil->visi ?? "Website resmi desa",
        ];
        
        if ($profil->telepon) {
            $schema["telephone"] = $profil->telepon;
        }
        
        if ($profil->email) {
            $schema["email"] = $profil->email;
        }
        
        if ($profil->alamat_lengkap) {
            $schema["address"] = [
                "@type" => "PostalAddress",
                "streetAddress" => $profil->alamat_lengkap,
                "addressLocality" => $profil->kecamatan,
                "addressRegion" => $profil->provinsi,
                "postalCode" => $profil->kode_pos,
                "addressCountry" => "ID"
            ];
        }
        
        if ($profil->latitude && $profil->longitude) {
            $schema["geo"] = [
                "@type" => "GeoCoordinates",
                "latitude" => (string) $profil->latitude,
                "longitude" => (string) $profil->longitude
            ];
        }
        
        return $schema;
    }
    
    /**
     * Generate structured data for Article (Berita)
     * 
     * @param object $berita
     * @return array
     */
    public static function getArticleSchema($berita): array
    {
        $profil = ProfilDesa::getInstance();
        
        return [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $berita->judul,
            "description" => strip_tags(substr($berita->konten, 0, 200)),
            "image" => asset('storage/' . $berita->gambar),
            "datePublished" => $berita->created_at->toIso8601String(),
            "dateModified" => $berita->updated_at->toIso8601String(),
            "author" => [
                "@type" => "Organization",
                "name" => $profil->nama_desa ?? "Desa Warurejo"
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => $profil->nama_desa ?? "Desa Warurejo",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => $profil->logo ? asset('storage/' . $profil->logo) : asset('images/logo.png')
                ]
            ],
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => url()->current()
            ]
        ];
    }
    
    /**
     * Generate structured data for Place (Potensi Desa)
     * 
     * @param object $potensi
     * @return array
     */
    public static function getPlaceSchema($potensi): array
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Place",
            "name" => $potensi->nama,
            "description" => strip_tags(substr($potensi->deskripsi, 0, 200)),
            "image" => asset('storage/' . $potensi->gambar),
        ];
        
        if ($potensi->lokasi) {
            $schema["address"] = $potensi->lokasi;
        }
        
        if ($potensi->kontak) {
            $schema["telephone"] = $potensi->kontak;
        }
        
        return $schema;
    }
    
    /**
     * Generate breadcrumb structured data
     * 
     * @param array $items [['name' => 'Home', 'url' => '/'], ...]
     * @return array
     */
    public static function getBreadcrumbSchema(array $items): array
    {
        $listItems = [];
        
        foreach ($items as $index => $item) {
            $listItems[] = [
                "@type" => "ListItem",
                "position" => $index + 1,
                "name" => $item['name'],
                "item" => $item['url']
            ];
        }
        
        return [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $listItems
        ];
    }
}
