import AdminLayout from '@/Layouts/AdminLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { Plus, Pencil, Trash2 } from 'lucide-react';

export default function MessagesIndex({ messages }) {
    const { props } = usePage();
    const flash = props.flash || {};
    const destroy = (id) => confirm('Delete message?') && router.delete(`/admin/messages/${id}`);

    return (
        <AdminLayout title="Messages">
            <div className="space-y-6">
                {flash.success && (
                    <div className="p-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-xl text-sm border border-green-200 dark:border-green-700">✓ {flash.success}</div>
                )}
                <h2 className="font-bold text-slate-900 dark:text-white text-xl">Contact Messages</h2>
                <div className="card overflow-hidden">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                {['From', 'Subject', 'Date', 'Status', 'Actions'].map(h => (
                                    <th key={h} className="text-left px-4 py-3 text-slate-500 dark:text-slate-400 font-semibold text-xs uppercase tracking-wider">{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 dark:divide-slate-700">
                            {(messages || []).map(m => (
                                <tr key={m.id} className={`hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors ${!m.is_read ? 'font-semibold' : ''}`}>
                                    <td className="px-4 py-3">
                                        <p className="text-slate-900 dark:text-white">{m.name}</p>
                                        <p className="text-slate-400 text-xs">{m.email}</p>
                                    </td>
                                    <td className="px-4 py-3 text-slate-700 dark:text-slate-300">{m.subject || '—'}</td>
                                    <td className="px-4 py-3 text-slate-400 text-xs whitespace-nowrap">{new Date(m.created_at).toLocaleDateString()}</td>
                                    <td className="px-4 py-3">
                                        <span className={`badge text-xs ${m.is_read ? 'badge-slate' : 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 badge'}`}>
                                            {m.is_read ? 'Read' : 'Unread'}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3">
                                        <div className="flex gap-2">
                                            <Link href={`/admin/messages/${m.id}`} className="btn-ghost p-1.5"><Pencil size={14}/></Link>
                                            <button onClick={() => destroy(m.id)} className="btn-ghost p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20"><Trash2 size={14}/></button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                            {(!messages || messages.length === 0) && (
                                <tr><td colSpan={5} className="px-4 py-8 text-center text-slate-400">No messages yet.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
