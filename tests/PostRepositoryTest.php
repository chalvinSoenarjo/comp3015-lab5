<?php

require_once __DIR__ . '/../src/Repositories/PostRepository.php';
require_once __DIR__ . '/../src/Models/Post.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

use src\Repositories\PostRepository;

class PostRepositoryTest extends TestCase
{
	private PostRepository $postRepository;

	public function __construct(?string $name = null, array $data = [], $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}

	/**
	 * Runs before each test
	 */
    protected function setUp(): void
    {
        parent::setUp();

        // Load .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Initialize your repository or other setup tasks
        $this->postRepository = new PostRepository();
    }


    /**
	 * Runs after each test
	 */
    protected function tearDown(): void
    {
        parent::tearDown();

        // Assuming you've loaded .env variables already
        $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'];
        $pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
        // The rest of your teardown code
    }



    public function testPostCreation()
	{
		$post = (new PostRepository)->savePost('test', 'body');
		$this->assertEquals('test', $post->title);
		$this->assertEquals('body', $post->body);
	}

    public function testPostRetrieval()
    {
        // Assuming savePost and getPostById methods exist
        $savedPost = $this->postRepository->savePost('Test Title', 'Test Body');
        $postId = $savedPost->id; // Assuming the saved post returns an ID.

        $retrievedPost = $this->postRepository->getPostById($postId);

        $this->assertNotNull($retrievedPost);
        $this->assertEquals('Test Title', $retrievedPost->title);
        $this->assertEquals('Test Body', $retrievedPost->body);
    }


    public function testPostUpdate()
    {
        // Insert a new post
        $post = $this->postRepository->savePost('Original Title', 'Original Body');
        $postId = $post->id;

        // Update the post
        $this->postRepository->updatePost($postId, 'Updated Title', 'Updated Body');

        // Retrieve the updated post
        $updatedPost = $this->postRepository->getPostById($postId);

        $this->assertEquals('Updated Title', $updatedPost->title);
        $this->assertEquals('Updated Body', $updatedPost->body);
    }


    public function testPostDeletion()
    {
        // Insert a new post
        $post = $this->postRepository->savePost('Delete Test', 'Delete Body');
        $postId = $post->id;

        // Delete the post
        $this->postRepository->deletePost($postId);

        // Try to retrieve the deleted post
        $deletedPost = $this->postRepository->getPostById($postId);

        $this->assertNull($deletedPost);
    }

}
