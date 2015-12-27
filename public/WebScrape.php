<?php
class WebScrape {
    /**
     * Scrape page with curl
     * @param  string $url url to page
     * @return string      scraped page
     */
    private function scrapeWithCurl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7 (.NET CLR 3.5.30729)'
        );
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * Scrape one
     * @param  string $url          url to page to scrape
     * @param  string $pattern      regex pattern
     * @return string array         text
     */
    public function scrapeOne($url, $pattern) {
        if (!$html = $this->scrapeWithCurl($url)) {
            return false;
        }
        preg_match($pattern, $html, $content);
        return $content;
    }

    /**
     * Scrape all
     * @param  string $url          url to page to scrape
     * @param  string $pattern      regex pattern
     * @return string array         text
     */
    public function scrapeAll($url, $pattern) {
        if (!$html = $this->scrapeWithCurl($url)) {
            return false;
        }
        preg_match_all($pattern, $html, $content);
        return $content;
    }

    /**
     * Is url found
     * @param  string $url url to page to check
     * @return boolean      true = exists
     */
    public function urlExists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $retcode > 400 -> not found, $retcode = 200, found.
        curl_close($ch);
        if ($retcode >= 400) {
            return false;
        } else if ($retcode = 200) {
            return true;
        }
    }
}