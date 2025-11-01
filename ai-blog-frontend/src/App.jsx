import { useEffect, useState } from 'react';

function PostCard({ post }) {
  return (
    <article className="card">
      <h3>{post.title}</h3>
      <p className="meta">Szerző: {post.author || 'Ismeretlen'} — Álláspont: {post.stance}</p>
      <p>{post.content.slice(0, 200)}{post.content.length > 200 ? '…' : ''}</p>
      <p className="tags">Címkék: {(post.tags || []).join(', ')}</p>
      <p className="date">{post.published_at ? new Date(post.published_at).toLocaleString() : ''}</p>
    </article>
  );
}

export default function App() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch('http://localhost:8000/api/v1/posts')
      .then(r => r.json())
      .then(data => {

        setPosts(data.data ?? data);
      })
      .catch(err => console.error(err))
      .finally(() => setLoading(false));
  }, []);

  return (
    <div className="container">
      <header>
        <h1>AI a suliban — blog</h1>
        <p>Megvitatjuk: használat = csalás? vagy segítő eszköz?</p>
      </header>

      {loading ? <p>Betöltés…</p> : (
        <section className="grid">
          {posts.map(p => <PostCard key={p.id} post={p} />)}
        </section>
      )}

      <footer>© AI-blog — iskola & etika</footer>
    </div>
  );
}