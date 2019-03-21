<?php
declare(strict_types=1);

namespace Yireo\Webp2\Browser;

use Magento\Framework\HTTP\Header;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class BrowserSupport
 *
 * @package Yireo\Webp2\Browser
 */
class BrowserSupport
{
    /**
     * @var Header
     */
    private $headerService;

    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * BrowserSupport constructor.
     *
     * @param Header $headerService
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        Header $headerService,
        CookieManagerInterface $cookieManager
    ) {
        $this->headerService = $headerService;
        $this->cookieManager = $cookieManager;
    }

    /**
     * @return bool
     */
    public function hasWebpSupport(): bool
    {
        if ($this->isChromeBrowser()) {
            return true;
        }


        if ((int)$this->cookieManager->getCookie('webp') === 1) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function isChromeBrowser(): bool
    {
        $userAgent = $this->headerService->getHttpUserAgent();

        // Chrome 9 or higher
        if (preg_match('/Chrome\/([0-9]+)/', $userAgent, $match)) {
            if ($match[1] > 9) {
                return true;
            }
        }

        return false;
    }
}
