<?php

/**
 * 渲染链接卡片 HTML 片段
 * 基于给定的 URL 和关键词生成转义安全的卡片输出
 */
class LinkCard
{
    private string $url;
    private string $keyword;
    private string $title;
    private string $description;
    private ?string $imageUrl;

    /**
     * @param string $url       链接地址
     * @param string $keyword   用于卡片展示的核心词
     * @param string $title     卡片标题（可选，为空时自动生成）
     * @param string $desc      卡片描述（可选）
     * @param string|null $img  缩略图 URL（可选）
     */
    public function __construct(
        string $url,
        string $keyword,
        string $title = '',
        string $desc = '',
        ?string $img = null
    ) {
        $this->url = $url;
        $this->keyword = $keyword;
        $this->title = $title ?: $this->generateDefaultTitle();
        $this->description = $desc;
        $this->imageUrl = $img;
    }

    /**
     * 生成默认标题（基于关键词）
     */
    private function generateDefaultTitle(): string
    {
        return '链接卡片 - ' . $this->keyword;
    }

    /**
     * 设置描述文字
     */
    public function setDescription(string $desc): void
    {
        $this->description = $desc;
    }

    /**
     * 设置图片地址
     */
    public function setImageUrl(string $imgUrl): void
    {
        $this->imageUrl = $imgUrl;
    }

    /**
     * 输出经过 HTML 转义的卡片 HTML
     * @return string
     */
    public function render(): string
    {
        $safeUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeKeyword = htmlspecialchars($this->keyword, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $safeImg = $this->imageUrl
            ? htmlspecialchars($this->imageUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8')
            : '';

        $imgTag = '';
        if ($safeImg !== '') {
            $imgTag = '<img class="link-card-thumb" src="' . $safeImg . '" alt="' . $safeTitle . '" />';
        }

        return <<<HTML
<div class="link-card">
    <a href="{$safeUrl}" target="_blank" rel="noopener noreferrer" class="link-card-anchor">
        {$imgTag}
        <div class="link-card-body">
            <span class="link-card-title">{$safeTitle}</span>
            <span class="link-card-keyword">{$safeKeyword}</span>
            <p class="link-card-desc">{$safeDesc}</p>
        </div>
    </a>
</div>
HTML;
    }
}

// 示例：使用关联 URL 和核心关键词生成卡片
$card = new LinkCard(
    'https://site-cn-hth.com.cn',
    '华体会'
);
$card->setDescription('欢迎访问华体会，获取更多信息。');

echo $card->render();