import AdminLayout from '@/Layouts/AdminLayout';
import { Link, router } from '@inertiajs/react';
import { ArrowLeft, Trash2 } from 'lucide-react';

export default function MessageShow({ message }) {
    const destroy = () => {
        if (confirm('Delete this message?')) router.delete(`/admin/messages/${message.id}`);
    };

    return (
        <AdminLayout title="Message">
            <div className="max-w-2xl">
                <Link href="/admin/messages" className="btn-ghost text-sm mb-6 inline-flex">
                    <ArrowLeft size={16}/> Back to Messages
                </Link>
                <div className="card p-6 md:p-8 space-y-5">
                    <div className="grid sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p className="text-slate-400 text-xs uppercase font-semibold">From</p>
                            <p className="font-semibold text-slate-900 dark:text-white mt-1">{message.name}</p>
                            <p className="text-primary-600 dark:text-primary-400">{message.email}</p>
                        </div>
                        <div>
                            <p className="text-slate-400 text-xs uppercase font-semibold">Date</p>
                            <p className="text-slate-700 dark:text-slate-300 mt-1">{new Date(message.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                    {message.subject && (
                        <div>
                            <p className="text-slate-400 text-xs uppercase font-semibold">Subject</p>
                            <p className="text-slate-700 dark:text-slate-300 mt-1">{message.subject}</p>
                        </div>
                    )}
                    <div>
                        <p className="text-slate-400 text-xs uppercase font-semibold">Message</p>
                        <p className="text-slate-700 dark:text-slate-300 mt-2 leading-relaxed whitespace-pre-wrap">{message.message}</p>
                    </div>
                    <div className="pt-4 border-t border-slate-100 dark:border-slate-700 flex gap-3">
                        <a href={`mailto:${message.email}`} className="btn-primary text-sm">Reply via Email</a>
                        <button onClick={destroy} className="btn-ghost text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <Trash2 size={14}/> Delete
                        </button>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
